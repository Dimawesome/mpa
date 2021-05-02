<?php

namespace App\Http\Controllers\Admin;

use App\Models\MenuItem;
use App\Models\Module;
use App\Models\Page;
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;
use Illuminate\Contracts\Container\BindingResolutionException;

/**
 * Class PageController
 *
 * @package App\Http\Controllers\Admin
 */
class PageController extends Controller
{
    /**
     * @var Page
     */
    private Page $page;

    /**
     * @var Module
     */
    private Module $module;

    /**
     * @var MenuItem
     */
    private MenuItem $menu;

    /**
     * PageController constructor.
     *
     * @param Page $page
     * @param Module $module
     * @param MenuItem $menu
     */
    public function __construct(Page $page, Module $module, MenuItem $menu)
    {
        $this->page = $page;
        $this->module = $module;
        $this->menu = $menu;
    }

    /**
     * @param Request $request
     * @return View
     */
    public function index(Request $request): View
    {
        return \view('admin.pages.index', [
            'items' => $this->page->search($request)
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return View
     */
    public function listing(Request $request): View
    {
        return \view('admin.pages._list', [
            'items' => $this->page->search($request)->paginate($request->per_page)
        ]);
    }

    /**
     * Disable page
     *
     * @param Request $request
     * @param string $puid
     * @return JsonResponse
     */
    public function disable(Request $request, string $puid): JsonResponse
    {
        if ($pageItem = $this->page->findByUid($puid)) {
            $pageItem->disable();
            $request->session()->flash('alert-success', trans('app.admin.page.disabled'));
        } else {
            $request->session()->flash('alert-error', trans('app.notify.something_went_wrong'));
        }

        return response()->json([
            'url' => route('admin.page')
        ]);
    }

    /**
     * Enable page
     *
     * @param Request $request
     * @param string $puid
     * @return JsonResponse
     */
    public function enable(Request $request, string $puid): JsonResponse
    {
        if ($pageItem = $this->page->findByUid($puid)) {
            $pageItem->enable();
            $request->session()->flash('alert-success', trans('app.admin.page.enabled'));
        } else {
            $request->session()->flash('alert-error', trans('app.notify.something_went_wrong'));
        }

        return response()->json([
            'url' => route('admin.page')
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param Request $request
     * @param string|null $puid
     * @return Application|Factory|RedirectResponse|View
     */
    public function create(Request $request, ?string $puid = null)
    {
        if (!empty($request->old())) {
            $this->page->fill($request->old());
        }

        if (!$puid) {
            $this->page->save();

            return redirect()->action('Admin\PageController@create', $this->page->uid);
        }

        $pageItem = $this->page->findByUid($puid);

        return \view('admin.pages.create', [
            'page' => $pageItem,
            'view' => false,
            'modules' => $pageItem ? $this->module->sortByOrder($this->module->getPageModules($pageItem->id)) : null
        ]);
    }

    /**
     * Store the specified data
     *
     * @param Request $request
     * @return RedirectResponse
     * @throws ValidationException
     * @throws Exception
     */
    public function store(Request $request): RedirectResponse
    {
        if ($pageItem = $this->page->findByUid($request->post('puid'))) {
            $post = $request->post();

            if (isset($post['cancel_btn']) && $post['cancel_btn'] === 'cancel') {
                $pageItem->delete();
            } else {
                $this->validate($request, $this->page->rules());
                $pageItem->fill($post);

                $pageItem->save()
                    ? $request->session()->flash('alert-success', trans('app.admin.page.created'))
                    : $request->session()->flash('alert-error', trans('app.notify.something_went_wrong'));
            }
        } else {
            $request->session()->flash('alert-error', trans('app.notify.something_went_wrong'));
        }

        return redirect()->route('admin.page');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Request $request
     * @param string $puid
     * @return Application|Factory|View|RedirectResponse
     */
    public function edit(Request $request, string $puid)
    {
        $pageItem = $this->page->findByUid($puid);

        if ($pageItem && !$pageItem->is_deleted) {
            if (!empty($request->old())) {
                $pageItem->fill($request->old());
            }

            return view('admin.pages.edit', [
                'page' => $pageItem,
                'view' => false,
                'modules' => $this->module->sortByOrder($this->module->getPageModules($pageItem->id))
            ]);
        }

        $request->session()->flash('alert-error', trans('app.notify.something_went_wrong'));

        return redirect()->route('admin.page');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @return RedirectResponse
     * @throws ValidationException
     */
    public function update(Request $request): RedirectResponse
    {
        $post = $request->post();

        if ($request->isMethod('patch') && $pageItem = $this->page->findByUid($post['puid'])) {
            if (!isset($post['cancel_btn']) || $post['cancel_btn'] !== 'cancel') {
                $this->validate($request, $this->page->rules());
                $pageItem->fill($post);
                $pageItem->is_active = $post['is_active'] ?? 0;
                $pageItem->save()
                    ? $request->session()->flash('alert-success', trans('app.admin.page.updated'))
                    : $request->session()->flash('alert-error', trans('app.notify.something_went_wrong'));
            }
        } else {
            $request->session()->flash('alert-error', trans('app.notify.something_went_wrong'));
        }

        return redirect()->route('admin.page');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Request $request
     * @param string $puid
     * @return Application|Factory|View|RedirectResponse
     */
    public function view(Request $request, string $puid)
    {
        $pageItem = $this->page->findByUid($puid);

        if ($pageItem && $pageItem->is_deleted) {
            return \view('admin.pages.view', [
                'page' => $pageItem,
                'view' => true,
                'modules' => $this->module->sortByOrder($this->module->getPageModules($pageItem->id))
            ]);
        }

        $request->session()->flash('alert-error', trans('app.notify.something_went_wrong'));

        return redirect()->route('admin.page');
    }

    /**
     * Remove the specified resource
     *
     * @param Request $request
     * @param string $puid
     * @return JsonResponse
     * @throws Exception
     */
    public function remove(Request $request, string $puid): JsonResponse
    {
        if ($pageItem = $this->page->findByUid($puid)) {
            $pageItem->is_deleted = 1;
            $pageItem->disable();
            $pageItem->save();
            $request->session()->flash('alert-success', trans('app.admin.page.removed'));
        } else {
            $request->session()->flash('alert-error', trans('app.notify.something_went_wrong'));
        }

        return response()->json([
            'url' => route('admin.page')
        ]);
    }

    /**
     * Delete the specified resource
     *
     * @param Request $request
     * @param string $puid
     * @return JsonResponse
     * @throws Exception
     */
    public function delete(Request $request, string $puid): JsonResponse
    {
        if ($pageItem = $this->page->findByUid($puid)) {
            $pageItem->delete();
            $request->session()->flash('alert-success', trans('app.admin.page.deleted'));
        } else {
            $request->session()->flash('alert-error', trans('app.notify.something_went_wrong'));
        }

        return response()->json([
            'url' => route('admin.page.trash')
        ]);
    }

    /**
     * Restore the specified resource
     *
     * @param Request $request
     * @param string $puid
     * @return JsonResponse
     * @throws Exception
     */
    public function restore(Request $request, string $puid): JsonResponse
    {
        if ($pageItem = $this->page->findByUid($puid)) {
            $pageItem->is_deleted = 0;
            $pageItem->save();
            $request->session()->flash('alert-success', trans('app.admin.page.restored'));
        } else {
            $request->session()->flash('alert-error', trans('app.notify.something_went_wrong'));
        }

        return response()->json([
            'url' => route('admin.page.trash')
        ]);
    }

    /**
     * Delete all the specified resources
     *
     * @param Request $request
     * @return JsonResponse
     * @throws Exception
     */
    public function deleteAll(Request $request): JsonResponse
    {
        $this->page->deleteAll();
        $request->session()->flash('alert-success', trans('app.admin.trash_cleaned'));

        return response()->json([
            'url' => route('admin.page.trash')
        ]);
    }

    /**
     * @param Request $request
     * @return View
     */
    public function trash(Request $request): View
    {
        return \view('admin.pages.trash', [
            'items' => $this->page->search($request, true)
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return View
     */
    public function trashListing(Request $request): View
    {
        return \view('admin.pages._trash_list', [
            'items' => $this->page->search($request, true)->paginate($request->per_page)
        ]);
    }

    /**
     * Show page with content and files
     *
     * @param Request $request
     * @param string $slug
     * @param string $muid
     * @param string $puid
     * @return Application|Factory|View|RedirectResponse
     * @throws BindingResolutionException
     */
    public function page(Request $request, string $slug, string $muid, string $puid)
    {
        if (($pageItem = $this->page->findByUid($puid)) && $menuItem = $this->menu->findByUid($muid)) {
            return $this->page->getPage(
                $pageItem,
                $this->module->sortByOrder($this->module->getModulesWithAdditionalData($pageItem->id, true)),
                $menuItem
            );
        }

        return redirect()->route('dashboard');
    }

    /**
     * Return page for preview
     *
     * @param string $puid
     * @return Application|Factory|View|string
     * @throws BindingResolutionException
     */
    public function preview(string $puid)
    {
        if ($pageItem = $this->page->findByUid($puid)) {
            return $this->page->getPage(
                $pageItem,
                $this->module->sortByOrder($this->module->getModulesWithAdditionalData($pageItem->id, true)),
                null,
                'admin.pages.preview',
                true
            );
        }

        return '';
    }
}
