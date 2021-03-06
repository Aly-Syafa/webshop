<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

$factory->define(App\Droit\Colloque\Entities\Colloque::class, function (Faker\Generator $faker) {
    return [
        'titre'           => 'My big event',
        'soustitre'       => 'Sous-titre du colloque',
        'sujet'           => 'sujet du colloque',
        'remarques'       => '',
        'start_at'        => \Carbon\Carbon::now(),
        'end_at'          => null,
        'registration_at' => \Carbon\Carbon::now(),
        'active_at'       => null,
        'organisateur'    => 'Cindy Leschaud',
        'location_id'     => 1,
        'compte_id'       => 1,
        'visible'         => 1,
        'bon'             => 1,
        'facture'         => 1,
        'adresse_id'      => 1,
    ];
});

$factory->define(App\Droit\Inscription\Entities\Inscription::class, function (Faker\Generator $faker) {
    return [
        'colloque_id'    => 39,
        'inscription_no' => $faker->numberBetween(11, 71).'-2015/'.$faker->numberBetween(1, 5),
        'user_id'        => 710,
        'group_id'       => null,
        'price_id'       => $faker->numberBetween(200,300),
        'created_at'     => \Carbon\Carbon::now(),
        'updated_at'     => \Carbon\Carbon::now()
    ];
});

$factory->define(App\Droit\Inscription\Entities\Groupe::class, function (Faker\Generator $faker) {
    return [
        'id'          => 1,
        'colloque_id' => 39,
        'user_id'     => 710,
        'description' => 'Une description',
        'adresse_id'  => null,
    ];
});

$factory->define(App\Droit\Option\Entities\Option::class, function (Faker\Generator $faker) {
    return [
        'id'          => 1,
        'colloque_id' => 1,
        'title'       => 'Option',
        'type'        => 'checkbox',
    ];
});

$factory->define(App\Droit\Price\Entities\Price::class, function (Faker\Generator $faker) {
    return [
        'id'          => 1,
        'colloque_id' => 1,
        'price'       => 4000,
        'type'        => 'public',
        'description' => 'test',
        'rang'        => 1,
        'remarque'    => 'test',
    ];
});

$factory->define(App\Droit\Option\Entities\OptionGroupe::class, function (Faker\Generator $faker){
    return [
        'id'          => 1,
        'colloque_id' => 1,
        'option_id'   => 1,
        'text'        => 'Groupe',
    ];
});

$factory->define(App\Droit\Option\Entities\OptionUser::class, function (Faker\Generator $faker){
    return [
        'user_id'          => 1,
        'option_id'        => 1,
        'inscription_id'   => 1,
        'groupe_id'        => null,
        'reponse'          => '',
    ];
});

$factory->define(App\Droit\Occurrence\Entities\Occurrence::class, function (Faker\Generator $faker){
    return [
        'start_at'     => \Carbon\Carbon::now()->addDay(),
        'location_id'  => 1,
        'colloque_id'  => 1,
        'title'        => 'Titre'
    ];
});

$factory->define(App\Droit\User\Entities\User::class, function (Faker\Generator $faker) {
    return [
        'first_name' => $faker->firstName,
        'last_name'  => $faker->lastName,
        'email'      => $faker->email,
        'password'   => bcrypt(str_random(10))
    ];
});

$factory->define(App\Droit\Inscription\Entities\Participant::class, function (Faker\Generator $faker) {
    return [
        'name'           => 'Cindy Leschaud',
        'inscription_id' => '10-2016/2'
    ];
});

$factory->define(App\Droit\Specialisation\Entities\Specialisation::class, function (Faker\Generator $faker) {
    return [
        'title' => 'title'
    ];
});

$profession = \App::make('App\Droit\Profession\Repo\ProfessionInterface');
$canton     = \App::make('App\Droit\Canton\Repo\CantonInterface');
$pays       = \App::make('App\Droit\Pays\Repo\PaysInterface');

$professions = $profession->getAll()->lists('title','id')->all();
$cantons     = $canton->getAll()->lists('title','id')->all();

$factory->define(App\Droit\Adresse\Entities\Adresse::class, function (Faker\Generator $faker) use ($professions,$cantons) {
    return [
        'civilite_id'  => $faker->numberBetween(1,4),
        'first_name'   => $faker->firstName,
        'last_name'    => $faker->lastName,
        'email'        => $faker->email,
        'company'      => $faker->company,
        'profession_id' => array_rand($professions, 1),
        'telephone'    => $faker->phoneNumber,
        'mobile'       => $faker->phoneNumber,
        'fax'          => $faker->phoneNumber,
        'adresse'      => $faker->address,
        'npa'          => $faker->postcode,
        'ville'        => $faker->city,
        'canton_id'     => array_rand($cantons, 1),
        'pays_id'      => 208,
        'type'         => 1,
        'user_id'      => 0,
        'livraison'    => 1
    ];
});

/*
 * SHOP FACTORIES
 */

$factory->define(App\Droit\Shop\Product\Entities\Product::class, function (Faker\Generator $faker) {
    return [
        'id'              => 100,
        'title'           => 'Test product',
        'teaser'          => 'test',
        'image'           => 'test.jpg',
        'description'     => 'test' ,
        'weight'          => 900,
        'sku'             => 1,
        'price'           => 1000,
        'is_downloadable' => 0,
        'hidden'          => 0,
    ];
});


$factory->define(App\Droit\Shop\Order\Entities\Order::class, function (Faker\Generator $faker) {
    return [
        'id'          => 100,
        'user_id'     => 1,
        'coupon_id'   => null,
        'payement_id' => 1,
        'order_no'    => '2015-00000004',
        'amount'      => 10000,
        'shipping_id' => 1,
        'onetimeurl'  => null
    ];
});

$factory->defineAs(App\Droit\Shop\Coupon\Entities\Coupon::class, 'one', function (Faker\Generator $faker) {

    $tomorrow = \Carbon\Carbon::now()->addDay();

    return [
        'id'         => 100,
        'value'      => '10',
        'type'       => 'general',
        'title'      => 'test',
        'expire_at'  => $tomorrow
    ];
});


$factory->define(App\Droit\Shop\Shipping\Entities\Shipping::class, function (Faker\Generator $faker) {

    return [
        'id'         => 100,
        'title'      => 'Envoi par Poste <2kg',
        'value'      => '2000',
        'price'      => '1000',
        'type'       => 'poids',
    ];
});

$factory->define(App\Droit\Shop\Cart\Entities\Cart::class, function (Faker\Generator $faker) {

    return [
        'id'        => 1,
        'user_id'   => 1,
        'coupon_id' => null,
        'cart'      => serialize([1,2,3]),
    ];
});

$factory->defineAs(App\Droit\Shop\Coupon\Entities\Coupon::class, 'two', function (Faker\Generator $faker) {

    $tomorrow = \Carbon\Carbon::now()->addDay();

    return [
        'id'         => 200,
        'value'      => '20',
        'type'       => 'product',
        'title'      => 'second',
        'expire_at'  => $tomorrow
    ];
});

$factory->defineAs(App\Droit\Shop\Coupon\Entities\Coupon::class, 'three', function (Faker\Generator $faker) {

    $tomorrow = \Carbon\Carbon::now()->addDay();

    return [
        'value'      => '0',
        'type'       => 'shipping',
        'title'      => 'freeshipping',
        'product_id' => null,
        'expire_at'  => $tomorrow
    ];
});

$factory->define(App\Droit\Newsletter\Entities\Newsletter_users::class, function (Faker\Generator $faker) {
    return [
        'id'           => $faker->numberBetween(50,150),
        'email'        => $faker->email,
        'token'        => '1234',
        'activated_at' => date('Y-m-d G:i:s')
    ];
});

$factory->define(App\Droit\Newsletter\Entities\Newsletter_subscriptions::class, function (Faker\Generator $faker) {
    return [
        'user_id'       => 1,
        'newsletter_id' => 1
    ];
});

$factory->define(App\Droit\Newsletter\Entities\Newsletter::class, function (Faker\Generator $faker) {
    return [
        'id'           => 1,
        'titre'        => 'Titre',
        'list_id'      => '1',
        'from_name'    => 'Nom',
        'from_email'   => 'cindy.leschaud@gmail.com',
        'return_email' => 'cindy.leschaud@gmail.com',
        'unsuscribe'   => 'unsubscribe',
        'preview'      => 'droit.local',
        'logos'        => 'logos.jpg',
        'header'       => 'header.jpg',
        'color'        => '#fff'
    ];
});

$factory->define(App\Droit\Newsletter\Entities\Newsletter_campagnes::class, function (Faker\Generator $faker) {
    return [
        'sujet'         => 'Sujet',
        'auteurs'       => 'Cindy Leschaud',
        'status'        => 'Brouillon',
        'newsletter_id' => 1
    ];
});

$factory->define(App\Droit\Author\Entities\Author::class, function (Faker\Generator $faker) {
    return [
        'first_name' => 'Cindy',
        'last_name'  => 'Leschaud',
        'occupation' => 'Webmaster',
        'bio'        => 'Test',
        'photo'      => 'cindy.jpg',
        'rang'       => 1
    ];
});

$factory->define(App\Droit\Abo\Entities\Abo::class, function (Faker\Generator $faker) {
    return [
        'title' => 'Test',
        'plan'  => 'month',
        'logo'  => 'logo.png',
        'name'  => 'Test'
    ];
});

$factory->define(App\Droit\Abo\Entities\Abo_users::class, function (Faker\Generator $faker) {
    return [
        'abo_id'         => 1,
        'numero'         => 123,
        'exemplaires'    => 1,
        'adresse_id'     => '',
        'tiers_id'       => '',
        'price'          => 1000,
        'reference'      => '',
        'remarque'       => '',
        'status'         => '',
        'renouvellement' => ''
    ];
});

$factory->define(App\Droit\Abo\Entities\Abo_factures::class, function (Faker\Generator $faker) {
    return [
        'abo_user_id' => 1,
        'product_id'  => 1,
        'payed_at'    => null
    ];
});

$factory->define(App\Droit\Shop\Attribute\Entities\Attribute::class, function (Faker\Generator $faker) {
    return [
        'id'    => 3,
        'title' => 'REF'
    ];
});