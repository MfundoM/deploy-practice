<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Password;
use Laravel\Nova\Fields\Text;

class Admin extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Models\Admin::class;

    /**
     * The logical group associated with the resource.
     *
     * @var string
     */
    public static $group = 'Members';

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'name';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id',
        'first_name',
        'last_name',
        'email',
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

            Boolean::make('Super Admin')
                ->rules('required', 'boolean')
                ->help('Super Admins can manage other admins and see job queues etc.'),

            Text::make('First Name')
                ->rules('required', 'max:255')
                ->sortable(),

            Text::make('Last Name')
                ->rules('required', 'max:255')
                ->sortable(),

            Text::make('Email')
                ->rules('required', 'email', 'max:255')
                ->creationRules('unique:admins,email')
                ->updateRules('unique:admins,email,{{resourceId}}')
                ->sortable(),

            Password::make('Password')
                ->creationRules('required', 'string', 'min:8')
                ->updateRules('nullable', 'string', 'min:8')
                ->onlyOnForms(),

            Text::make('Role')
                ->rules('nullable', 'max:255')
                ->sortable(),

            DateTime::make('Created At')
                ->hideWhenCreating()
                ->hideWhenUpdating(),

            DateTime::make('Updated At')
                ->onlyOnDetail(),
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
