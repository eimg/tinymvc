#TinyMVC
TinyMVC is a PHP micro framework with MVC router, especially design to quickly bootstrap REST app without unnecessary overhead and complexity. Requires Apache mod_rewrite and PHP short open tag.

##Getting Start

###config.php

Set the default controller and sqlite database in <code>config.php</code>
<pre><code>
$config = array(
	"db" => "data/db.sqlite",
	"default-controller" => "home"
);
</code></pre>

###router.php

Set the route pattern in <code>router.php</code>
<pre><code>
$route = array("controller", "action", "id");
</code></pre>

<code>controller</code> always should be the first value in route map.

##Model-View-Controller

###Controllers
Controllers are the key and most important components. Each request go to respective controller. For example, if the request is <code>http://example.com/home/add/123</code>, that will reach to <code>home</code> controller (controllers/home.php) with the additional parameters (add/123). Since the route map is <code>controller/action/id</code>, "add" would be "action" and "123" would be "id".

There are two example controllers included (<code>home.php</code> and <code>todo.php</code>). Take a look at home controller for view-template based apps. Take a look at todo controller for API apps.

In default configuration, <code>home</code> has been set as "default-controller". So, if there is no controller pointed in request URL, <code>home</code> will be use as default controller.

###Views 
Views are optional and not necessary in API apps. But, it's useful if you want to build a typical template based apps with TinyMVC. Each template set should be store in <code>views</code> directory by organization with sub-directory that has same name with controller.

Main wrapper template is stored in <code>template/index.php</code>. Other necessary static resources should also store under respective directories in <code>template</code> directory.

###Models
Models are also optionals. Models should have same name with controller and should be store in <code>models</code> directory. TinyMVC will use the models if exists.

###Controls
When you need to add CSS Link, JS Source, Links, Images and Forms to your view template, you should use build-in controls instead of raw HTML. Take a look at <code>template/index.php</code> for example. You might also want to check available controls in <code>includes/controls.php</code>. And, you may extend it as you like for more richer control-set.

###More
For more information, view the example controllers and other source codes.

##Licenses
Tinymvc is license under <a href="http://rem.mit-license.org">MIT License</a>. Please feel free to use, modify and redistribute.
