# laravel_orion
Laravel Orion allows you to build a fully featured REST API based on your Eloquent models and relationships  with simplicity of Laravel as you love it

------------------------------------------------------------------------------------------------
Used:- 
-> Laravel Orion allows you to build a fully featured REST API based on your Eloquent models and relationships
 with simplicity of Laravel as you love it
------------------------------------------------------------------------------------------------

Youtube link :- https://www.youtube.com/watch?v=eVvxLvkeXUM&list=PLFZAa7EupbB5AswPlSTpd9vq7ifHXjiBp&index=2
------------------------------------------------------------------------------------------------

Installition:
-> composer create-project laravel/laravel:^9.0 laravel-orion
-> composer require tailflow/laravel-orion
-> composer require laravel/sanctum
-> php artisan vendor:publish
	- PN : Laravel\Sanctum\SanctumServiceProvider (need to be search which number of set this provider)

------------------------------------------------------------------------------------------------
Database setup:-
-> .env
-> php artisan migrate

------------------------------------------------------------------------------------------------

User Model (if you have used new version so this is already there)
->  use HasApiTokens, HasFactory, Notifiable;
------------------------------------------------------------------------------------------------

Auth (config/auth.php)
->  'api' => [
            'driver' => 'sanctum',
            'provider' => 'users',
            'hash' => false,
    ],

------------------------------------------------------------------------------------------------

=> set postman collcetion variable of top folder
Variables: 			INITIAL VALUE				Current value
API_URL 			localhost:8000/api  		localhost:8000/api

------------------------------------------------------------------------------------------------
Now add fake data with using tinker
-> php artisan tinker

$user = User::factory()->create([
'name' => 'himanshu',
'email' => 'himanshu3110@yopmail.com',
])
------------------------------------------------------------------------------------------------


-> $user->createToken('play')
result is : +plainTextToken: "1|HTuZhvNhzfzLgGlIfvPsuuCiRcMe7o5CYWfuwpml",

copy and paste token in a postman collection form authentication filed

------------------------------------------------------------------------------------------------
Run the api is the postman:

{{API_URL}}/user
------------------------------------------------------------------------------------------------
++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
================================================================================================
||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||
------------------------------------------------------------------------------------------------

NOW Create Posts Collection

create model and controller for it.
-> php artisan make:model Post --factory --migration

------------------------------------------------------------------------------------------------
Add this code in PostFactory.php 
->    public function definition()
    {
        return [
            'title' => $this->faker->sentence(),
            'body' => $this->faker->paragraph(),
        ];
    }
------------------------------------------------------------------------------------------------

fake post data:
-> php artisan tinker
-> Post::factory()->create()
-> Post::factory()->count(10)->create()

------------------------------------------------------------------------------------------------
After need to be create floder inside of controller name of 'Api' and another one folder create 'PostsController' inside of Api Folder:

-> <?php

namespace App\Http\Controllers\Api;

use Orion\Http\Controllers\Controller;

class PostController extends Controller{
    protected $model = Post::class;

}

------------------------------------------------------------------------------------------------

After create new Route in api.php 

Route::group(['as' => 'api.'], function () {
    Orion::resource('posts', PostsController::class);
})

------------------------------------------------------------------------------------------------
create new policy with cmd
-> php artisan make:policy PostPolicy --model=Post
------------------------------------------------------------------------------------------------

php artisan route:list --name posts

________________________________________________________________________________________________
________________________________________________________________________________________________

________________________________________________________________________________________________

****************   Set Environment authentication token in Admin and Client on PostMan Collection **********************
________________________________________________________________________________________________

Drop all tables, views, and types with cmd:
-> php artisan db:wipe 
------------------------------------------------------------------------------------------------

create table
- php artisan make:migration add_published_and_category_columns_to_posts_table
------------------------------------------------------------------------------------------------

added two column in posts table 
-> Schema::table('posts', function (Blueprint $table) {
     $table->boolean('publshed')->default(false);
     $table->string('category')->default('none');
    });

- php artisan migrate
------------------------------------------------------------------------------------------------
added new two filed fake data in factory:- PostFactory.php

return [
    'title' => $this->faker->sentence(),
    'body' => $this->faker->paragraph(),
    'published' => $this->faker->boolean(),
    'category' => $this->faker->word(),
];

------------------------------------------------------------------------------------------------
-> php artisan tinker
-> post::factory()->create()

------------------------------------------------------------------------------------------------
php artisan db:wipe
------------------------------------------------------------------------------------------------
add new data using seeder file (DatabaseSeeder.php)

public function run()
{
    \App\Models\Post::factory(3)->create(["category" => "this is first category"]);
    \App\Models\Post::factory(3)->create(["category" => "this is second category"]);
    \App\Models\Post::factory(3)->create(["category" => "this is third category"]);
    \App\Models\Post::factory(3)->create(["category" => "this is forth category"]);
    \App\Models\Post::factory(3)->create(["category" => "this is fifth category"]);


    // \App\Models\User::factory(10)->create();
    // \App\Models\User::factory()->create([
    //     'name' => 'Test User',
    //     'email' => 'test@example.com',
    // ]);
}

------------------------------------------------------------------------------------------------
adding data using seeder:

1. php artisan migrate
2. php artisan db:seed

using as above cmd in single cmd
-> php artisan migrate --seed
------------------------------------------------------------------------------------------------

create admin token

-> php artisan tinker
-> User::factory()->create()->createToken('passport')

------------------------------------------------------------------------------------------------
create two environement on postman 
- admin
- client

=> set admin postman collcetion variable of top folder
Variables:          INITIAL VALUE               Current value
accessToken         1|rBqDo8yx3c5t17cM1xQdsX7AeuXlr44z33INZFFN


=> set client postman collcetion variable of top folder
Variables:          INITIAL VALUE               Current value
accessToken                                     my-access-token

------------------------------------------------------------------------------------------------
set variable on postman collection 

set Authentication
Token : {{accessToken}}

------------------------------------------------------------------------------------------------
________________________________________________________________________________________________

**********************************   Search functionality **********************************
________________________________________________________________________________________________

Create function searchableBy in PostController.php

    public function searchableBy(): array
    {
        return ['title', 'body', 'category'];
    }
------------------------------------------------------------------------------------------------
In postman add this 
{
    "search": {
        "value": "this is second category"
    }
}
________________________________________________________________________________________________
________________________________________________________________________________________________

**********************************   filter functionality **********************************
________________________________________________________________________________________________

add this function in controller

public function filterableBy(): array
{
    return ['title', 'body', 'created_at', 'updated_at', 'published', 'id', 'category'];
}
------------------------------------------------------------------------------------------------

set in postman body->raw (json formate)
{
    "filters": [
        {
        "field": "id",
        "operator": "in",
        "value": [1, 4, 6]
        }
    ]
}
------------------------------------------------------------------------------------------------
{
    "filters": [
        {
        "field": "category",
        "operator": "=",
        "value": "this is first category"
        }
    ]
}
------------------------------------------------------------------------------------------------
{
    "filters": [
        {
        "field": "created_at",
        "operator": "<=",
        "value": "2023-04-28T06:42:18.000000Z"
        }
    ]
}
------------------------------------------------------------------------------------------------
________________________________________________________________________________________________

**********************************   Sort functionality **********************************
________________________________________________________________________________________________

add this function in controller

public function sortableBy(): array
{
    return ['title', 'category'];
}
------------------------------------------------------------------------------------------------
{
    "sort": [
        {
            "field": "category",
            "direction": "asc"   
        }
    ]
}
------------------------------------------------------------------------------------------------
{
    "sort": [
        {
            "field": "category",
            "direction": "desc"   
        },
        {
            "field": "title",
            "direction": "desc"   
        }
    ]
}
------------------------------------------------------------------------------------------------
------------------------------------------------------------------------------------------------
________________________________________________________________________________________________

**********************************   Scope functionality **********************************
________________________________________________________________________________________________

In models(Post.php) 
->   
public function scopepublished($query)
{
    return $query->where('published', true);
}

public function scopeWhereCategory($query, $category)
{
    return $query->where('category', $category);
}
------------------------------------------------------------------------------------------------

In Controllers(PostController)
->
public function sortableBy(): array
{
    return ['title', 'category'];
}

public function exposedScopes(): array
{
    return ['published', 'whereCategory'];
}
------------------------------------------------------------------------------------------------
set in postman body->raw (json formate)

{
    "scopes": [
        {
            "name": "published"   
        },
        {
            "name": "whereCategory",
            "parameters": ["this is third category"]
        }
    ]
}
------------------------------------------------------------------------------------------------
------------------------------------------------------------------------------------------------
________________________________________________________________________________________________

**********************************   Pagination functionality **********************************
________________________________________________________________________________________________

->php artisan tinker
>> Post::factory(200)->create()

In postman 
add key and value
key: page = value: 6

Url : {{API_URL}}/posts?page=6

------------------------------------------------------------------------------------------------

PN: You want to disable paginate
-> In top of PostController: 
use Orion/Concerns/DisablePagination;

-> in function 
use DisablePagination
------------------------------------------------------------------------------------------------
------------------------------------------------------------------------------------------------
________________________________________________________________________________________________

**********************************   Soft Delete functionality **********************************
________________________________________________________________________________________________

In post model(Post.php)

-> use Illuminate\Database\Eloquent\SoftDeletes;

-> use SoftDeletes;
------------------------------------------------------------------------------------------------

create migration:
-> php artisan make:migration add_soft_deletes_to_posts_table

------------------------------------------------------------------------------------------------
------------------------------------------------------------------------------------------------
________________________________________________________________________________________________

*********************  with_trashed / only_trashed functionality *******************************
------------------------------------------------------------------------------------------------
------------------------------------------------------------------------------------------------


{{API_URL}}/posts?with_trashed=true
{{API_URL}}/posts?only_trashed

------------------------------------------------------------------------------------------------
------------------------------------------------------------------------------------------------
________________________________________________________________________________________________

**********************************  Tinker cmd *************************************************
------------------------------------------------------------------------------------------------

-> php artisan tinker
>> Post::count()
>> Post::withTrashed()
>> Post::withTrashed()->get()
>> Post::withTrashed()->count()
>> Post::onlyTrashed()
>> Post::onlyTrashed()->get()
>> Post::first()
>> Post::first()->delete()
>> Post::find(50)
>> Post::withTrashed()->find(50)
>> Post::withTrashed()->find(50)->restore()
>> Post::find(50)->forceDelete()

------------------------------------------------------------------------------------------------
