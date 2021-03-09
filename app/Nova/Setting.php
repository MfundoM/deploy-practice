<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Textarea;

class Setting extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Models\Setting::class;

    /**
     * The logical group associated with the resource.
     *
     * @var string
     */
    public static $group = 'Options';

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'key';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'key',
    ];

    /**
     * Get the fields displayed by the resource.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function fields(Request $request)
    {
        return [
            ID::make()->sortable(),

            Text::make('Key')
                ->rules('required', 'string', 'max:255')
                ->creationRules('unique:settings,key')
                ->updateRules('unique:settings,key,{{resourceId}}')
                ->readonly()
                ->sortable(),

            Select::make('Type')
                ->rules('required', Rule::in(array_keys(\App\Models\Setting::$types)))
                ->options(\App\Models\Setting::$types),

            Textarea::make('Value', function () {
                return \App\Helpers\Settings::setValueForType($this->value, $this->type);
            })->alwaysShow()->hideWhenUpdating(),

            Textarea::make('Value')
                ->rules('nullable', 'string', 'max:65500')
                ->resolveUsing(function ($value) {
                    return \App\Helpers\Settings::setValueForType($this->value, $this->type);
                })->hideFromDetail(),
        ];
    }

    /**
     * Get the cards available for the request.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function cards(Request $request)
    {
        return [];
    }

    /**
     * Get the filters available for the resource.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function filters(Request $request)
    {
        return [];
    }

    /**
     * Get the lenses available for the resource.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function lenses(Request $request)
    {
        return [];
    }

    /**
     * Get the actions available for the resource.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function actions(Request $request)
    {
        return [];
    }
}
