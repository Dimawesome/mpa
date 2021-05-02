<?php

namespace App\Models;

use Illuminate\Container\Container;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

/**
 * Class Module
 *
 * @package App\Models
 */
class Module extends BaseModel
{
    use HasFactory;

    /**
     * Get validation rules.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'module' => 'required'
        ];
    }

    /**
     * Get all page modules
     *
     * @param int $pid
     * @param bool $active
     * @return array|null
     */
    public function getPageModules(int $pid, bool $active = false): ?array
    {
        $pageModules = [];
        $modules = $this->getAll();

        foreach ($modules as $module) {
            $pageModules[] = DB::table($module->table_name)
                ->where('page_id', '=', $pid)
                ->where(function ($query) use ($active) {
                    if ($active) {
                        $query->where('is_active', '=', true);
                    }
                })->get()->toArray();
        }

        return $pageModules ? Arr::collapse($pageModules) : null;
    }

    /**
     * Get page modules with additional data from tables
     *
     * @param int $pid
     * @param bool $active
     * @return array|null
     * @throws BindingResolutionException
     */
    public function getModulesWithAdditionalData(int $pid, bool $active = false): ?array
    {
        $modules = $this->getPageModules($pid, $active);

        foreach ($modules as $module) {
            $model = $this->getModelObj($module->name);

            if (method_exists($model, 'getAdditionalData')) {
                $module->additional_data = $model->getAdditionalData($module);
            }
        }

        return $modules;
    }

    /**
     * Save modules order
     *
     * @param array|null $items
     * @return bool
     * @throws BindingResolutionException
     */
    public function saveModulesOrder(?array $items): bool
    {
        $order = 1;
        if ($items) {
            foreach ($items as $item) {
                if (isset($item['name'])) {
                    if (
                        ($moduleObject = $this->getModelObj($item['name']))
                        && ($moduleItem = $moduleObject->findByUid($item['uid']))
                    ) {
                        $moduleItem->order = $order;
                        $moduleItem->save();

                        ++$order;
                    } else {
                        return false;
                    }
                }
            }
        }

        return true;
    }

    /**
     * Get max order number
     *
     * @param int|null $pid
     * @return int
     */
    public function getMaxOrder(?int $pid): int
    {
        $modules = $this->sortByOrder($this->getPageModules($pid));

        return $modules ? last($modules)->order + 1 : 1;
    }

    /**
     * Get model's object
     *
     * @param string $module
     * @return File|Text|null
     * @throws BindingResolutionException
     */
    public function getModelObj(string $module)
    {
        $array = [
            'text' => Text::class,
            'file' => File::class
        ];

        return $module !== null
            ? Container::getInstance()->make($array[$module])
            : null;
    }

    /**
     * Get module select options
     *
     * @return array
     */
    public function getSelectOptions(): array
    {
        $modules = $this->getAll();
        $select = [];

        foreach ($modules as $module) {
            $select[] = [
                'value' => $module['name'],
                'text' => trans("app.admin.module.{$module['name']}")
            ];
        }

        return $select;
    }

    /**
     * Get allowed role list
     *
     * @param $module
     * @return array|Application|Translator|string|null
     */
    public static function getAllowedRoleList($module)
    {
        $roles = DB::table("module_{$module->name}")->select('visible_to')
            ->where('uid', '=', $module->uid)
            ->get()->first();

        return Role::getRoleList($roles);
    }

    /**
     * Save or update records
     *
     * @param $model
     * @param Request $request
     * @param int|null $pid
     * @param int|null $order
     * @return bool
     * @throws BindingResolutionException
     */
    public function saveRecords($model, Request $request, ?int $pid, ?int $order = null): bool
    {
        $post = collect($request->post('modal'))->pluck('value', 'name')->all();

        $model->fill($post);

        if ($pid && $this->saveModulesOrder($request->post('main'))) {
            $model->name = $post['module'];
            $model->page_id = $pid;
            $model->is_active = $post['is_active'] ?? 0;
            $model->order = $order ?? $model->order;

            if ($model->save()) {
                if (method_exists($model, 'saveAdditionalRecords')) {
                    $model->saveAdditionalRecords($post);
                }

                return true;
            }
        }

        return false;
    }

    /**
     * Validate modal
     *
     * @param array $data
     * @return JsonResponse|null
     */
    public function validateModal(array $data): ?JsonResponse
    {
        $errors = Validator::make($data, $this->rules());

        if ($errors->fails()) {
            return response()->json([
                'type' => 'error',
                'errors' => $errors->errors()
            ]);
        }

        return null;
    }
}
