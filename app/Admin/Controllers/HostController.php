<?php

namespace App\Admin\Controllers;

use App\Models\Host;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class HostController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Host';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Host());

        $grid->column('id', __('Id'));
        $grid->column('first_name', __('First name'));
        $grid->column('national_code', __('National code'));
        $grid->column('phone_number', __('Phone number'));
        $grid->column('email', __('Email'));
        $grid->column('is_confirm', __('Is confirm'))->sortable()->bool();
        $grid->hotel()->name();

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
        $show = new Show(Host::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('first_name', __('First name'));
        $show->field('last_name', __('Last name'));
        $show->field('national_code', __('National code'));
        $show->field('phone_number', __('Phone number'));
        $show->field('email', __('Email'));
        $show->field('is_confirm', __('Is confirm'))->bool();
        $show->field('created_at', __('Created at'));
        $show->field('updated_at', __('Updated at'));
        $show->field('deleted_at', __('Deleted at'));

        $show->hotel('The host hotels information', function ($host) {

            $host->setResource('/admin/hotels');
            $host->name();
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
        $form = new Form(new Host());

        $form->text('first_name', __('First name'));
        $form->text('last_name', __('Last name'));
        $form->number('national_code', __('National code'));
        $form->number('phone_number', __('Phone number'));
        $form->email('email', __('Email'));
        $form->switch('is_confirm', __('Is confirm'));

        return $form;
    }
}
