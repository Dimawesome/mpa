<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MenuItem;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class MenuItemController extends Controller
{
    /**
     * @var MenuItem
     */
    protected MenuItem $menuItem;

    /**
     * MenuController constructor.
     *
     * @param MenuItem $menuItem
     */
    public function __construct(MenuItem $menuItem)
    {
        $this->menuItem = $menuItem;
    }

    /**
     * Display a listing of the resource.
     *
     * @return View
     */
    public function index(): View
    {
        return view('admin.menu_items.index', [
            'items' => $this->menuItem->getAll()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param Request $request
     * @return Application|Factory|View
     */
    public function create(Request $request)
    {
        $this->menuItem->uid = '0';
        $this->menuItem->status = 'inactive';
//        $pages = MenuItem::getActivePageList($menu->uid);

        // TODO make pages fetch
        $pages = [
            [
                'value' => '1',
                'text' => 'Page 1'
            ],
            [
                'value' => '2',
                'text' => 'Page 2'
            ],
            [
                'value' => '3',
                'text' => 'Page 3'
            ],
        ];

        if (!empty($request->old())) {
            $this->menuItem->fill($request->old());
        }

        return \view('admin.menu_items.create', [
            'menu' => $this->menuItem->toArray(),
            'rules' => $this->menuItem->rules(),
            'pages' => $pages
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return RedirectResponse
     * @throws ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        if ($request->isMethod('post')) {
            $menu = new MenuItem();
            $post = $request->post();

            $this->validate($request, $menu->rules());

            $menu->fill($post);

            $menu->creator_id = $request->user()->id;
            $menu->language = 'lt';
            $menu->target = isset($post['external_url']) ? '_blank' : null;

            if ($menu->save()) {
                if ($post['menu_url'] === MenuItem::PAGE_TYPE) {
                    $menu->url = isset($post[$post['menu_url']])
                        ? $this->createPageUrl($menu, $post[$post['menu_url']])
                        : null;
                } else {
                    $menu->url = $post[$post['menu_url']];
                }

                $menu->url_type = $menu->url ? $post['menu_url'] : null;
                $menu->save();
                $request->session()->flash('alert-success', trans('app.menu_created'));
            }
        }

        return redirect()->action('Admin\MenuController@index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Request $request
     * @param $uids
     * @return Application|Factory|View
     */
    public function edit(Request $request, $uids)
    {
        $menu = MenuItem::findByUid($uids);
        $menu->visible_to = json_decode($menu->visible_to, true);
        $pages = MenuItem::getActivePageList($menu->uid);

        if (!empty($request->old())) {
            $menu->fill($request->old());
        }

        return view('admin.menu.edit',
            compact('menu', 'pages')
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param string $uid
     * @return RedirectResponse
     * @throws ValidationException
     */
    public function update(Request $request, string $uid): RedirectResponse
    {
        if ($request->isMethod('patch')) {
            $menu = MenuItem::findByUid($uid);
            $post = $request->post();

            $this->validate($request, $menu->rules());

            $menu->is_default = $post['is_default'] ?? 0;

            if (!$menu->is_default || is_super_admin()) {
                $menu->name = $post['name'];
            }

            if (!isset($post['status'])) {
                $menu->status = 'inactive';
            } else {
                $menu->status = 'active';
            }

            if (!$menu->is_default || is_super_admin()) {
                if ($post['menu_url'] === MenuItem::PAGE_TYPE) {
                    $menu->url = isset($post[$post['menu_url']]) ? $this->createPageUrl($menu, $post[$post['menu_url']]) : null;
                } else {
                    $menu->url = $post[$post['menu_url']];
                }

                $menu->url_type = $menu->url ? $post['menu_url'] : null;
            }

            $menu->type = $post['type'];
            $menu->target = isset($post['external_url']) ? '_blank' : null;
            $menu->language = App::getLocale();
            $menu->visible_to = json_encode($request->visible_to, JSON_NUMERIC_CHECK) !== 'null'
                ? json_encode($request->visible_to, JSON_NUMERIC_CHECK)
                : null;

            if ($menu->save()) {
                $request->session()->flash('alert-success', trans('app.menu_updated'));
            }
        }

        return redirect()->action('Admin\MenuController@index');
    }

    /**
     * Disable the specified resource
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function disable(Request $request): RedirectResponse
    {
        $items = MenuItem::whereIn('uid', explode(',', $request->uids));

        foreach ($items->get() as $item) {
            $item->disable();
        }

        $request->session()->flash('alert-success', trans('app.item.disabled'));

        return redirect()->action('Admin\MenuController@index');
    }

    /**
     * Enable the specified resource
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function enable(Request $request): RedirectResponse
    {
        $items = MenuItem::whereIn('uid', explode(',', $request->uids));

        foreach ($items->get() as $item) {
            $item->enable();
        }

        $request->session()->flash('alert-success', trans('app.item.enabled'));

        return redirect()->action('Admin\MenuController@index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function delete(Request $request): RedirectResponse
    {
        $items = MenuItem::whereIn('uid', explode(',', $request->uids));

        foreach ($items->get() as $item) {
            if (!$item->is_default) {
                $item->delete();
            }
        }

        $request->session()->flash('alert-success', trans('app.menu_deleted'));

        return redirect()->action('Admin\MenuController@index');
    }

    /**
     * Create page url
     *
     * @param MenuItem $menu
     * @param array $puids
     * @return string
     */
    public function createPageUrl(MenuItem $menu, array $puids): string
    {
        foreach ($puids as $uid) {
            $pages[] = '/' . Page::findByUid($uid)->page_name . '/' . Str::slug($menu->name, '-') . "/{$menu->uid}/$uid";
        }

        return json_encode($pages);
    }
}
