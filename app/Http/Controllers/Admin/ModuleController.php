<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Module;
use App\Models\Page;
use Exception;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;

/**
 * Class ModuleController
 *
 * @package App\Http\Controllers\Admin
 */
class ModuleController extends Controller
{
    /**
     * @var Module
     */
    public Module $module;

    /**
     * @var Page
     */
    public Page $page;

    /**
     * ModuleController constructor
     *
     * @param Module $module
     * @param Page $page
     */
    public function __construct(Module $module, Page $page)
    {
        $this->module = $module;
        $this->page = $page;
    }

    /**
     * Show the form for creating a new resource
     *
     * @param string $puid
     * @return View
     */
    public function create(string $puid): View
    {
        return \view('admin.modules.create', [
            'puid' => $puid,
            'module' => $this->module,
            'additionalData' => $this->module->getSelectOptions(),
            'view' => false
        ]);
    }

    /**
     * Store module data
     *
     * @param Request $request
     * @param string $puid
     * @return JsonResponse|null
     * @throws BindingResolutionException
     */
    public function store(Request $request, string $puid): ?JsonResponse
    {
        $moduleData = collect($request->post('modal'))->pluck('value', 'name')->all();
        $errors = $this->module->validateModal($moduleData);
        $moduleItem = $this->module->getModelObj($moduleData['module']);

        if ($moduleItem && !$errors) {
            $errors = $moduleItem->validateModal($moduleData);
            $pid = $this->page->findByUid($puid)->id;
            $order = $this->module->getMaxOrder($pid);

            if (!$errors && $this->module->saveRecords($moduleItem, $request, $pid, $order)) {
                return response()->json([
                    'type' => 'success',
                    'title' => trans('app.notify.success'),
                    'message' => trans('app.admin.module.added'),
                    'listReload' => true
                ]);
            }

            return $errors;
        }

        return $errors;
    }

    /**
     * Show the form for editing the specified resource
     *
     * @param Request $request
     * @param string $uid
     * @param string $name
     * @param string $puid
     * @return Application|Factory|View|RedirectResponse
     * @throws BindingResolutionException
     */
    public function edit(Request $request, string $uid, string $name, string $puid)
    {
        if (
            ($moduleObject = $this->module->getModelObj($name))
            && ($moduleItem = $moduleObject->findByUid($uid))
            && !$this->page->findByUid($puid)->is_deleted
        ) {

            return \view('admin.modules.edit', [
                'module' => $moduleItem,
                'rules' => array_merge($this->module->rules(), $moduleObject->rules()),
                'additionalData' => $this->module->getSelectOptions(),
                'data' => method_exists($moduleItem, 'getAdditionalData')
                    ? $moduleItem->getAdditionalData($moduleItem)
                    : [],
                'puid' => $puid,
                'view' => false
            ]);
        }

        $request->session()->flash('alert-error', trans('app.notify.something_went_wrong'));

        return redirect()->back();
    }

    /**
     * Update the specified resource in storage
     *
     * @param Request $request
     * @param $puid
     * @return JsonResponse|null
     * @throws BindingResolutionException
     */
    public function update(Request $request, $puid): ?JsonResponse
    {
        $moduleData = collect($request->post('modal'))->pluck('value', 'name')->all();
        $errors = $this->module->validateModal($moduleData);
        $pageItem = $this->page->findByUid($puid);

        if (
            !$errors
            && $pageItem
            && !$pageItem->is_deleted
            && $request->isMethod('patch')
            && ($moduleObject = $this->module->getModelObj($moduleData['module']))
            && ($moduleItem = $moduleObject->findByUid($moduleData['uid']))
        ) {
            $errors = $moduleObject->validateModal($moduleData);

            if (!$errors && $this->module->saveRecords($moduleItem, $request, $pageItem->id)) {
                return response()->json([
                    'type' => 'success',
                    'title' => trans('app.notify.success'),
                    'message' => trans('app.admin.module.updated'),
                    'listReload' => true
                ]);
            }

            return $errors;
        }

        return $errors;
    }

    /**
     * Show the form for editing the specified resource
     *
     * @param Request $request
     * @param string $uid
     * @param string $name
     * @param string $puid
     * @return Application|Factory|View|RedirectResponse
     * @throws BindingResolutionException
     */
    public function view(Request $request, string $uid, string $name, string $puid)
    {
        if (
            ($moduleObject = $this->module->getModelObj($name))
            && ($moduleItem = $moduleObject->findByUid($uid))
        ) {

            $additionalData = array_merge(
                $this->module->getSelectOptions(),
                method_exists($moduleItem, 'getAdditionalData')
                    ? $moduleItem->getAdditionalData($moduleItem)
                    : []
            );

            return \view('admin.modules.view', [
                'module' => $moduleItem,
                'rules' => [],
                'additionalData' => $additionalData,
                'puid' => $puid,
                'view' => true
            ]);
        }

        $request->session()->flash('alert-error', trans('app.notify.something_went_wrong'));

        return redirect()->back();
    }

    /**
     * Sort items
     *
     * @param Request $request
     * @return JsonResponse
     * @throws BindingResolutionException
     */
    public function sort(Request $request): JsonResponse
    {
        $node = $request->post('node');

        if (isset($node) && !empty($node)) {
            $this->module->saveModulesOrder($node);

            return response()->json([
                'type' => 'success',
                'title' => trans('app.notify.success'),
                'message' => trans('app.admin.module.sorted')
            ]);
        }

        return response()->json([
            'type' => 'error',
            'title' => trans('error.notify.success'),
            'message' => trans('app.notify.something_went_wrong')
        ]);
    }

    /**
     * Enable the specified resource
     *
     * @param string $uid
     * @param string $name
     * @return JsonResponse
     * @throws BindingResolutionException
     */
    public function enable(string $uid, string $name): JsonResponse
    {
        if (($moduleObject = $this->module->getModelObj($name))
            && ($moduleItem = $moduleObject->findByUid($uid))
        ) {
            $moduleItem->enable();

            return response()->json([
                'type' => 'success',
                'title' => trans('app.notify.success'),
                'message' => trans('app.admin.module.enabled'),
                'listReload' => true
            ]);
        }

        return response()->json([
            'type' => 'error',
            'title' => trans('app.notify.error'),
            'message' => trans('app.notify.something_went_wrong'),
            'listReload' => true
        ]);
    }

    /**
     * Disable the specified resource
     *
     * @param string $uid
     * @param string $name
     * @return JsonResponse
     * @throws BindingResolutionException
     */
    public function disable(string $uid, string $name): JsonResponse
    {
        if (($moduleObject = $this->module->getModelObj($name))
            && ($moduleItem = $moduleObject->findByUid($uid))
        ) {
            $moduleItem->disable();

            return response()->json([
                'type' => 'success',
                'title' => trans('app.notify.success'),
                'message' => trans('app.admin.module.disabled'),
                'listReload' => true
            ]);
        }

        return response()->json([
            'type' => 'error',
            'title' => trans('app.notify.error'),
            'message' => trans('app.notify.something_went_wrong'),
            'listReload' => true
        ]);
    }

    /**
     * Delete the specified resource
     *
     * @param string $uid
     * @param string $name
     * @return JsonResponse
     * @throws BindingResolutionException
     * @throws Exception
     */
    public function delete(string $uid, string $name): JsonResponse
    {
        if (($moduleObject = $this->module->getModelObj($name))
            && ($moduleItem = $moduleObject->findByUid($uid))
        ) {
            $moduleItem->delete();

            return response()->json([
                'type' => 'success',
                'title' => trans('app.notify.success'),
                'message' => trans('app.admin.module.deleted'),
                'listReload' => true
            ]);
        }

        return response()->json([
            'type' => 'error',
            'title' => trans('app.notify.error'),
            'message' => trans('app.notify.something_went_wrong'),
            'listReload' => true
        ]);
    }

    /**
     * Get specified resource by uid
     *
     * @param Request $request
     * @return View
     * @throws BindingResolutionException
     */
    public function getModule(Request $request): View
    {
        return \view("admin.modules.partials._{$request->post('value')}", [
            'module' => $this->module->getModelObj($request->post('value')),
            'view' => false
        ]);
    }

    /**
     * Get module list
     *
     * @param string $puid
     * @return View
     */
    public function moduleList(string $puid): View
    {
        $pageItem = $this->page->findByUid($puid);

        return \view('admin.modules._list', [
            'modules' => $pageItem ? $this->module->sortByOrder($this->module->getPageModules($pageItem->id)) : null,
            'page' => $pageItem,
            'view' => $pageItem->is_deleted
        ]);
    }

    /**
     * Get module file list
     *
     * @param Request $request
     * @return View
     * @throws BindingResolutionException
     */
    public function fileList(Request $request): View
    {
        $moduleObj = $this->module->getModelObj('file');
        $post = $request->post();
        unset($post['_token']);

        if ($moduleObj) {
            return \view('admin.modules.partials._file_list', [
                'data' => $post,
                'rules' => $moduleObj->rules()
            ]);
        }
    }
}
