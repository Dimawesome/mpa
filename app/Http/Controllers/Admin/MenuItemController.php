<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MenuItem;
use App\Models\Page;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

/**
 * Class MenuItemController
 *
 * @package App\Http\Controllers\Admin
 */
class MenuItemController extends Controller
{
    /**
     * @var MenuItem
     */
    protected MenuItem $menuItem;

    /**
     * @var Page
     */
    protected Page $page;

    /**
     * MenuController constructor.
     *
     * @param MenuItem $menuItem
     * @param Page $page
     */
    public function __construct(MenuItem $menuItem, Page $page)
    {
        $this->menuItem = $menuItem;
        $this->page = $page;
    }

    /**
     * Display a listing of the resource.
     *
     * @return View
     */
    public function index(): View
    {
        return \view('admin.menu_items.index', [
            'items' => $this->menuItem->getAllSortedByOrder()->toArray()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|View
     */
    public function create()
    {
        return \view('admin.menu_items.create', [
            'menu' => $this->menuItem->toArray(),
            'rules' => $this->menuItem->rules(),
            'pages' => $this->menuItem->getActivePageList()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return JsonResponse
     * @throws ValidationException
     */
    public function store(Request $request): JsonResponse
    {
        if ($request->isMethod('post')) {
            $post = $request->post();

            $this->validate($request, $this->menuItem->rules());
            $this->menuItem->fill($post);
            $this->menuItem->order = $this->menuItem->getMaxOrder();

            if ($this->menuItem->save()) {
                $this->menuItem->url = isset($post['url'])
                    ? $this->menuItem->createPageUrl($this->menuItem, $post['url'])
                    : null;

                $this->menuItem->save();
                $request->session()->flash('alert-success', trans('app.admin.menu.created'));
            }

            $request->session()->flash('alert-error', trans('app.notify.something_went_wrong'));
        }

        return response()->json([
            'url' => route('admin.menu')
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return Application|Factory|View
     */
    public function edit(string $muid)
    {
        return \view('admin.menu_items.edit', [
            'menu' => $this->menuItem->findByUid($muid),
            'rules' => $this->menuItem->rules(),
            'pages' => $this->menuItem->getActivePageList($muid)
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @return JsonResponse
     * @throws ValidationException
     */
    public function update(Request $request): JsonResponse
    {
        $post = $request->post();
        $menu = $this->menuItem->findByUid($post['muid']);

        if ($menu && $request->isMethod('patch')) {
            $this->validate($request, $this->menuItem->rules());
            $menu->fill($post);
            $menu->is_active = $post['is_active'] ?? 0;
            $menu->url = isset($post['url'])
                ? $this->menuItem->createPageUrl($menu, $post['url'])
                : null;

            $menu->save()
                ? $request->session()->flash('alert-success', trans('app.admin.menu.updated'))
                : $request->session()->flash('alert-error', trans('app.notify.something_went_wrong'));
        }

        return response()->json([
            'url' => route('admin.menu')
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Request $request
     * @param string $muid
     * @return JsonResponse
     * @throws \Exception
     */
    public function delete(Request $request, string $muid): JsonResponse
    {
        if ($menu = $this->menuItem->findByUid($muid)) {
            $menu->delete();
            $request->session()->flash('alert-success', trans('app.admin.menu.deleted'));
        } else {
            $request->session()->flash('alert-error', trans('app.notify.something_went_wrong'));
        }

        return response()->json([
            'url' => route('admin.menu')
        ]);
    }

    /**
     * Sort items
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function sort(Request $request): JsonResponse
    {
        $node = $request->post('node');

        if (isset($node) && !empty($node)) {
            $this->menuItem->rebuildOrder($node);

            return response()->json([
                'type' => 'success',
                'title' => trans('app.notify.success'),
                'message' => trans('app.admin.menu.sorted')
            ]);
        }

        return response()->json([
            'type' => 'error',
            'title' => trans('error.notify.success'),
            'message' => trans('app.notify.something_went_wrong')
        ]);
    }
}
