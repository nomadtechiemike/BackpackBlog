<?php namespace AbbyJanke\Blog\app\Http\Controllers\Admin;

use Backpack\CRUD\app\Http\Controllers\CrudController;

use AbbyJanke\Blog\app\Http\Requests\Admin\ArticleCrudRequest as StoreRequest;
use AbbyJanke\Blog\app\Http\Requests\Admin\ArticleCrudRequest as UpdateRequest;

class ArticleCrudController extends CrudController {

	public function setup() {
		$this->crud->setModel('AbbyJanke\Blog\app\Models\Article');
    $this->crud->setRoute(config('backpack.base.route_prefix')  . '/blog/article');
    $this->crud->setEntityNameStrings('article', 'articles');

    $this->crud->denyAccess('show');
		$this->crud->setCreateView('blog::admin.create');
		$this->crud->setEditView('blog::admin.edit');

		// ------ CRUD COLUMNS
		$this->crud->addColumn([
			'name' => 'title',
			'label' => 'Title',
		]);

		$this->crud->addColumn([
			'name' => 'slug',
			'label' => 'Slug',
		]);

		$this->crud->addColumn([
			'label' => 'Primary Author',
			'type' => 'select',
			'name' => 'author_id',
			'entity' => 'author',
			'attribute' => 'name',
			'model' => "App\User",
		]);

		$this->crud->addColumn([
			'name' => 'created_at',
			'label' => 'Date Published',
			'type' => 'datetime'
		]);

		// ------ PRIMARY FIELDS
		$this->crud->addField([
			'name' => 'title',
			'label' => 'Title',
			'position' => 'main'
		]);

		$this->crud->addField([
			'name' => 'slug',
			'label' => 'Slug',
			'hint' => 'Automatically created if left empty.',
			'position' => 'main',
		]);

		$this->crud->addField([
			'name' => 'content',
	    'label' => 'Content',
	    'type' => 'wysiwyg',
			'position' => 'main'
		]);

		$this->crud->addField([
			'name' => 'author_id',
			'default' => \Auth::user()->id,
	    'type' => 'hidden',
			'position' => 'main'
		]);

		// ------ SIDEBAR FIELDS
		$this->crud->addField([
		  'label' => "Featured Image",
		  'name' => "featured_image",
		  'type' => 'base64_image',
			'aspect_ratio' => 1, // set to 0 to allow any aspect ratio
 			'position' => 'sidebar',
			'filename' => null
		]);

		$this->crud->addField([
	    'label' => "Featured Video",
	    'name' => "featured_video",
		  'type' => 'video',
 			'position' => 'sidebar',
		]);

		$this->crud->addField([
			'label'     => 'Category',
	    'type'      => 'checklist_create',
	    'name'      => 'categories',
	    'entity'    => 'categories',
	    'attribute' => 'name',
	    'model'     => "AbbyJanke\Blog\app\Models\Category",
			'route'			=> 'blog/category',
	    'pivot'     => true,
 			'position' => 'sidebar',
		]);

		$this->crud->addField([
			'label'     => 'Tag',
	    'type'      => 'checklist_create',
	    'name'      => 'tags',
	    'entity'    => 'tags',
	    'attribute' => 'name',
	    'model'     => "AbbyJanke\Blog\app\Models\Tag",
			'route'			=> 'blog/tag',
	    'pivot'     => true,
 			'position' => 'sidebar',
		]);

		$this->crud->addField([
			'label'     => 'Authors',
	    'type'      => 'select2_multiple',
	    'name'      => 'authors',
	    'entity'    => 'authors',
	    'attribute' => 'name',
	    'model'     => "App\User",
	    'pivot'     => true,
 			'position' => 'sidebar',
		]);

  }

	public function store(StoreRequest $request)
	{
		return parent::storeCrud();
	}

	public function update(UpdateRequest $request)
	{
		return parent::updateCrud();
	}
}
