<?php

namespace App\Http\Sections;

use SleepingOwl\Admin\Contracts\Display\DisplayInterface;
use SleepingOwl\Admin\Contracts\Form\FormInterface;
use SleepingOwl\Admin\Section;

use AdminColumn;
use AdminDisplay;
use AdminForm;
use AdminFormElement;
use SleepingOwl\Admin\Contracts\Initializable;

/**
 * Class NewsItemsSettings
 *
 * @property \App\NewsItem $model
 *
 * @see http://sleepingowladmin.ru/docs/model_configuration_section
 */
class NewsItemsSettings extends Section
{

    protected $model = '\App\NewsItemsSettings';

    public function initialize()
    {
        $this->addToNavigation($priority = 500, function() {
            return \App\NewsItemsSettings::count();
        });

        $this->creating(function($config, \Illuminate\Database\Eloquent\model $model) {
        });
    }


    /**
     * @see http://sleepingowladmin.ru/docs/model_configuration#ограничение-прав-доступа
     *
     * @var bool
     */
    protected $checkAccess = false;

    /**
     * @var string
     */
    protected $title = 'Настройки новостей';

    /**
     * @var string
     */
    protected $alias = 'newsitems';

    /**
     * @return DisplayInterface
     */
    public function onDisplay()
    {
        return AdminDisplay::table()
        ->setHtmlAttribute('class', 'table-primary')
        ->setColumns(

        AdminColumn::text('id', '#'),
        AdminColumn::link('title', 'Title'),
        AdminColumn::text('slug', 'Slug'),
    ) 

        ->paginate(12);
    }

    /**
     * @param int $id
     *
     * @return FormInterface
     */
    public function onEdit($id)
    {
        return AdminForm::panel()->addBody([
            AdminFormElement::text('id', 'ID#')->setReadOnly(1),
            AdminFormElement::text('title', 'Title')->required(),
            AdminFormElement::text('slug', 'Slug')->required()->unique(),
            AdminFormElement::ckeditor('description', 'Description')->required(),
            AdminFormElement::text('created_at', 'Created')->setReadOnly(1)
        ]);
    }

    /**
     * @return FormInterface
     */
    public function onCreate()
    {
        return AdminForm::panel()->addBody([
            AdminFormElement::text('title', 'Title')-> required(),
            AdminFormElement::text('slug', 'Slug')-> required()->unique(),
             AdminFormElement::ckeditor('description', 'Description')->required(),
        ]);
    }

    /**
     * @return void
     */
    public function onDelete($id)
    {
        // remove if unused
    }

    /**
     * @return void
     */
    public function onRestore($id)
    {
        // remove if unused
    }
}
