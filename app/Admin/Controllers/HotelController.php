<?php

namespace App\Admin\Controllers;

use App\Models\City;
use App\Models\Host;
use App\Models\Hotel;

use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class HotelController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Hotel';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Hotel());

        $grid->column('id', __('Id'));
        $grid->column('name', __('Name'));
        $grid->column('is_confirm', __('Is confirm'))->bool();
        $grid->column('title', __('Title'));
        $grid->column('description', __('Description'));
        $grid->column('motto', __('Motto'));
        $grid->host()->first_name();
        $grid->city()->name();

        return $grid;
    }

    /**
     * Make a show builder.
     *
     * @param mixed $id
     * @return Show
     */
    protected function detail($id)
    {
        $show = new Show(Hotel::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('name', __('Name'));
        $show->field('is_confirm', __('Is confirm'))->using([false => 'Not confirmed', true => 'Confirmed']);;
        $show->field('title', __('Title'));
        $show->field('slug', __('Slug'));
        $show->field('description', __('Description'));

        $show->host('Host information', function ($host) {

            $host->setResource('/admin/hosts');
            $host->first_name();
            $host->last_name();
            $host->national_code();
            $host->phone_number();
        });

        $show->city('City name', function ($city) {
            $city->name();
            $city->latitude();
            $city->longitude();
        });

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Hotel());

        $form->text('name', __('Name'));
        $form->switch('is_confirm', __('Is confirm'));
        $form->text('title', __('Title'));
        $form->hidden('slug', __('Slug'));
        $form->text('description', __('Description'));
        $form->text('motto', __('Motto'));
        $form->select('host_id')->options(Host::all()->pluck('first_name', 'id'));
        $form->select('city_id')->options(City::all()->pluck('name', 'id'));

        // images information

        // Multiple media field
        $form->multipleMediaLibrary('photos', 'Photos')
            ->responsive()
            ->removable();

        return $form;
    }
}
