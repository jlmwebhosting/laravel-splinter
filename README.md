# Splinter
Split testing for Laravel, made ridiculously easy.

## Installation

The easiest way to get Splinter is using Laravel's artisan CLI:

	php artisan bundle:install splinter

By default, Splinter uses a sqlite database to store its data. If you need to use another database, define it in `bundles/splinter/config/database.php`.


## Usage

First, we need to define our splits. For example, we want to split our landing page between two layouts: "carousel" and "outlier".

Hit the URI `/splinter` for the Splinter control panel. Add a new split named `landing-page` (or whatever you want to refer to it as), and then add two variations to that split, named `carousel` and `outlier`. The variation names point to the actual view files to be used, so if our `carousel` view was located at `application/views/alternate/carousel.blade.php`, the variation name would need to be `alternate.carousel`. Simple stuff.

In your controller code, where you want to display your view, whether it be an entire layout or just a partial, use this syntax:

	$view = Splinter\View::make('landing-page');

And that's it! The view is an extension of `Laravel\View`, so you can carry on just as before.

We also have Goals, which are defined in the Splinter control panel, and called in your code like so:

	Splinter\Splinter::convert('goal-name');

The bundle records statistics (just basic ones for now), which you can view in the control panel to help you improve your site or application.


## How does it work?

When a visitor hits a page that contains a Splinter view, the script randomly chooses a variation to display. The next time that visitor loads the page, they are greeted with the same variation. This does currently depend on browser cookies, so if your audience is likely to have cookies turned off, they might be a little confused to see a different version everytime they load your site.


## @TODO

There is still plenty to be done:

 - Authentication - This shouldn't be used on a production site without locking down the control panel.
 - Variation Groups - This will take a bit of work, but I can forsee the need to choose a variation for a group of partials, so for example you could set multiple partials on the same page to always show the same theme instead of each partial being a random variation.
 - Better Statistics - We're not collecting a ton of data here, but I believe we can come up with better ways to interpret the data we have, especially relating goals with variations.