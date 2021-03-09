<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\KeyValue;
use Laravel\Nova\Fields\MorphToActionTarget;
use Laravel\Nova\Fields\Status;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Textarea;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Resource;

class ActionResource extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string $model
     */
    public static $model = \App\Models\ActionEvent::class;

    /**
     * The logical group associated with the resource.
     *
     * @var string $group
     */
    public static $group = 'System';

    /**
     * Determine if the current user can create new resources.
     *
     * @param \Illuminate\Http\Request $request
     * @return bool
     */
    public static function authorizedToCreate(Request $request)
    {
        return false;
    }

    /**
     * Determine if the current user can edit resources.
     *
     * @param \Illuminate\Http\Request $request
     * @return bool
     */
    public function authorizedToUpdate(Request $request)
    {
        return false;
    }

    /**
     * Determine if the current user can delete resources.
     *
     * @param \Illuminate\Http\Request $request
     * @return bool
     */
    public function authorizedToDelete(Request $request)
    {
        return false;
    }

    /**
     * Get the fields displayed by the resource.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function fields(Request $request)
    {
        return [
            ID::make('ID', 'id'),

            Text::make('Action', 'name', function ($value) {
                return $value;
            }),

            Text::make('Initiated By', function () {
                return $this->user->name ?? $this->user->email ?? 'Nova User';
            }),

            MorphToActionTarget::make('Target', 'target'),

            Status::make('Status', 'status', function ($value) {
                return ucfirst($value);
            })->loadingWhen(['Waiting', 'Running'])->failedWhen(['Status']),

            $this->when(isset($this->original), function () {
                return KeyValue::make('Original');
            }),

            $this->when(isset($this->changes), function () {
                return KeyValue::make('Changes');
            }),

            Textarea::make('Exception'),

            DateTime::make('Actioned At', 'created_at')->exceptOnForms(),
        ];
    }

    /**
     * Build an "index" query for the given resource.
     *
     * @param \Laravel\Nova\Http\Requests\NovaRequest $request
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public static function indexQuery(NovaRequest $request, $query)
    {
        return $query->with('user');
    }

    /**
     * Determine if this resource is available for navigation.
     *
     * @param \Illuminate\Http\Request $request
     * @return bool
     */
    public static function availableForNavigation(Request $request)
    {
        return true;
    }

    /**
     * Determine if this resource is searchable.
     *
     * @return bool
     */
    public static function searchable()
    {
        return false;
    }

    /**
     * Get the displayable label of the resource.
     *
     * @return string
     */
    public static function label()
    {
        return 'Admin Actions';
    }

    /**
     * Get the displayable singular label of the resource.
     *
     * @return string
     */
    public static function singularLabel()
    {
        return __('Action');
    }

    /**
     * Get the URI key for the resource.
     *
     * @return string
     */
    public static function uriKey()
    {
        return 'action-events';
    }
}
