Run: composer require xuanhieu080/field-filter

Publish config: php artisan vendor:publish --tag=field-config

Model:
use FieldFilter\Traits\HasDynamicWith;

class User extends Model {
use HasDynamicWith;
}


Resource:
use FieldFilter\Resources\FlexibleResource;

class UserResource extends FlexibleResource { }

Controller:
User::withFields($request->query('fields'))->findOrFail($id);