<?php namespace AbbyJanke\Blog\app\Http\Controllers\Admin;

use Backpack\CRUD\app\Http\Controllers\CrudController;

use AbbyJanke\Blog\app\Http\Requests\Admin\ArticleCrudRequest as StoreRequest;
use AbbyJanke\Blog\app\Http\Requests\Admin\ArticleCrudRequest as UpdateRequest;

class CommentCrudController extends CrudController {

	public function setup() {
		$this->crud->setModel('AbbyJanke\Blog\app\Models\Comment');
    $this->crud->setRoute(config('backpack.base.route_prefix')  . '/blog/comment');
    $this->crud->setEntityNameStrings('comment', 'comments');

    $this->crud->allowAccess('show');
    $this->crud->removeButton('preview');

		$this->crud->addColumn([
			'label' => 'Author',
			'type' => 'model_function',
			'name' => 'author',
      'function_name' => 'displayAuthorFull'
		]);

		$this->crud->addColumn([
			'name' => 'comment',
			'label' => 'Comment',
			'type' => 'text'
		]);

		$this->crud->addColumn([
			'label' => 'In Response To',
			'type' => 'model_function',
			'name' => 'response_to',
      'function_name' => 'responseTo'
		]);

		$this->crud->addColumn([
			'name' => 'approved',
			'label' => 'Published',
			'type' => 'boolean'
		]);

		$this->crud->addColumn([
			'name' => 'created_at',
			'label' => 'Submitted On',
			'type' => 'datetime'
		]);

		$this->crud->addField([
			'name' => 'comment',
	    'label' => 'Comment',
	    'type' => 'textarea',
		]);

		$this->crud->addField([
			'name' => 'author_name',
			'label' => 'Author Name',
      'type' => 'text',
		]);

		$this->crud->addField([
			'name' => 'author_email',
			'label' => 'Author Email',
      'type' => 'text',
		]);

		$this->crud->addField([
			'name' => 'author_url',
			'label' => 'Author URL',
      'type' => 'text',
		]);

		$this->crud->addField([  // Select
     'label' => "Author Account",
     'type' => 'select',
     'name' => 'author_id',
     'entity' => 'author',
     'attribute' => 'name',
     'model' => "App\User"
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
