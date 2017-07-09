# TinyMVC

TinyMVC is a PHP micro framework with MVC router and responsive web design boilerplate, especially designed to quickly bootstrap web apps without unnecessary overhead and complexity. The structure and code are construct in simple imperative manner so that developer can get full understanding and control over base framework as well as the app.

Requires Apache mod_rewrite and PHP short open tags.

## Getting Start

### config.php

Set the default controller and database setting in <code>config.php</code>. TinyMVC currently supporting two database driver, MySQL and Sqlite.
<pre><code>
$config = array(
	## Sqlite
	"dbdriver" => "sqlite",
	"db" => "data/db.sqlite",

	## MySQL
	# "dbdriver" => "mysql",
	# "dbhost" => "127.0.0.1",
	# "dbuser" => "root",
	# "dbpass" => "",
	# "dbname" => "tinymvc",

	"default-controller" => "home"
);
</code></pre>

### router.php

Set the route pattern in <code>router.php</code>
<pre><code>
$route = array("controller", "action", "id");
</code></pre>

The default route map will handle the request in <code>controller/action/id</code> pattern. <code>controller</code> always should be the first value in route map.

## Model-View-Controller

### Controllers

Controllers are the key and most important components. Each request go to respective controller. For example, if the request is <code>http://example.com/home/add/123</code>, that will reach to <code>home</code> controller with the additional parameters, <code>add/123</code>. Since the route map is <code>controller/action/id</code>, "add" would be "action" and "123" would be "id" in this case.

Controllers files should stored in <code>controllers</code> directory. There are two example controllers included (<code>home.php</code> and <code>todo.php</code>). Take a look at home controller for view-template based apps. Take a look at todo controller for API apps.

In default configuration, <code>home</code> has been set as "default-controller". So, if there is no controller pointed in request URL, <code>home</code> will be use as default controller.

<code>redirect()</code> function can be use to redirect through router pattern. For example, </code>redirect("home/contact")</code> will immidiately redirect to <code>http://example.com/home/contact/</code>.

### Views

Views are optional and not necessary in API apps. But, it's useful for template based apps. Each template set should be store in <code>views</code> directory by organization with sub-directory that has the same name with controller.

Use <code>render()</code> function to wrap your template with template wrapper. You can pass the values to template through <code>$data</code> array.

<pre><code>
$data['one'] = "value one";
$data['two'] = "value two";

render("home", $data);
</code></pre>

In view, each index become variable and variables <code>$one</code> and <code>$two</code> would be available in this case. For security, you may use <code>f()</code> function for outputs, which filter potential XSS script.

Main wrapper HTML template is stored as <code>template/index.php</code>. Other necessary static resources should also store in respective directories under <code>template</code> directory.

### Models

Models are also optionals. A model file should have same name with controller and should be store in <code>models</code> directory. TinyMVC will use the models if exists.

### Controls

When you need to add CSS Link, JS Source, Hyperlinks, Images and Forms to your view template, you should use build-in controls instead of raw HTML. Take a look at <code>template/index.php</code> for example. You might also want to check available controls in <code>includes/controls.php</code>. And, you may extend it as you like for more richer control-set.

## REST Helper - Updated in build 20140817

TinyMVC now has additional REST helper functions <code>respond()</code>, <code>template()</code> and <code>http_auth()</code>. The purpose of <code>respond()</code> is to handle custom response header and content-type.

<pre><code>
respond($data, $status_code, $content_type);
</code></pre>

<code>$data</code> should be array. <code>$status_code</code> is optional and the default status code is <code>200 OK</code>. Please see <code>includes/core.php</code> for supported status codes. <code>$content_type</code> is also optional and default content type is <code>JSON</code>. Supported content types are JSON, HTML, Plain Text and JavaScript.

The purpose of <code>template()</code> is to respond pre-defined template (unlike <code>render()</code>, without wrapper) to API requests. Create pre-defined template files in <code>views/templates/</code>.

The purpose of <code>http_auth()</code> is to provide standard HTTP Authentication. Call it on top of API controller to add simple API authorization. Please don't forget to change username/password list. See the <code>http_auth()</code> function at <code>includes/core.php</code>.

### Action Map

TinyMVC also has action maping mechanism. To create an action map, create a map file in <code>controllers</code>. For example, if your controller file name is <code>api.php</code>, add <code>api.map.php</code> to define action map. Following is the syntax:

<pre><code>
$GET = array (
	"greet" => "hello",
	"leave" => "bye"
);

$POST = array (
	"foo" => "bar"
);
</code></pre>

For example, by given sample above, TinyMVC will invoke <code>hello()</code> function if the request method is <code>GET</code> and <code>action</code> parameter is <code>greet</code>. Just don't forget to define <code>hello()</code> function in controller.

<small>* Manual action mapping is required due to security reason instead of directly tying request action to function.</small>

### More

For more information, view the example controllers and other source codes. For example, you can check for available database methods in database wrapper class located in <code>includes/db.php</code>.

## Download

Source Code: <a href="https://github.com/eimg/tinymvc/">https://github.com/eimg/tinymvc/</a>

## Licenses

Tinymvc is license under <a href="https://github.com/eimg/tinymvc/blob/master/LICENSE.md">MIT License</a>. Please feel free to use, modify and redistribute as you wish.
