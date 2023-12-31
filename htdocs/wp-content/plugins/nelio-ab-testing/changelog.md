= 5.5.7 (July 4, 2023) =
* **Bug Fix.** Don’t load alternative content in WooCommerce while logged in as admin.
* **Bug Fix.** Tweak test links in “Overview” screen to print them under the popup help.
* **Bug Fix.** Fix error in JS WooCommerce listener.
* **Improvement.** Show error messages in “Account” page when something went wrong.
* **Improvement.** Prevent bundled items from being (incorrectly) tested.
* **Improvement.** Add “Add Test” button in “Overview” screen.
* **Improvement.** Add `nab` and `nab-x` body classes when previewing alternative content.
* **Improvement.** Add number of clicks above cursor in confetti view.
* **Improvement.** Add timestamp to API requests to prevent cache issues.
* **Improvement.** Trim license automatically to prevent issues when copying/pasting.
* **Improvement.** Remove existing nab cookies if GDPR consent was revoked.
* **Improvement.** Add new component to directly show support key in “Account” screen.

= 5.5.6 (June 1, 2023) =
* **Require WordPress 6.0**
* **Improvement.** Add `nab` and `nab-x` classes to body tag in tested pages.
* **Improvement.** Add new setting to specify (optional) GDPR cookie name.
* **Bug Fix.** Change (some) hook priorities from 9999 to 99 to fix main query issue.
* **Bug Fix.** Fix warning message in CSS editor.
* **Bug Fix.** Remove empty menu item from Dashboard.
* **Bug Fix.** Remove CodeMirror to fix CSS editor.
* **Bug Fix.** Collapse sidebar in CSS editor.
* **Bug Fix.** Fix undefined array index access in experiment REST API.
* **Bug Fix.** Fix admin bar’s quick actions on frontend.
* **Bug Fix.** Remove percentage symbol from revenue timeline chart.
* **Bug Fix.** Enqueue tracking script on OptimizePress pages with blank template.
* **Bug Fix.** Tweak CSS selector styles to maximize view.

= 5.5.4 (April 24, 2023) =
* **Bug Fix.** Add new helper function to safely retrieve values from objects.
* **Bug Fix.** Fix undefined array key warning in post, page, and CPT tests.

= 5.5.3 (March 24, 2023) =
* **WordPress 6.2.** Fix blank screen when creating/editing heatmap tests.
* **WordPress 6.2.** Start, preview, and trash tests from editor screen.
* **Bug Fix.** Fix invalid return statement in `useEffect` callback.

= 5.5.2 (March 23, 2023) =
* **New Feature.** Add support for Elementor form submissions in conversion actions.
* **Improvement.** Add class name selector in click conversion action.
* **Improvement.** Allow users to monitor the tracking events generated by our plugin using a custom JavaScript function named `nabMonitorTrackingEvents`.
* **Bug Fix.** Show conversion rates in overview screen.
* **Bug Fix.** Fix alternative preview dimensions to fit dialog’s content.
* **Bug Fix.** Remove support for external tracking, as it no longer works with current browsers.

= 5.5.1 (March 6, 2023) =
* **Bug Fix.** Track page view conversions when goal page is also tested (against another existing page).
* **Bug Fix.** Report tested product revenue only (instead of whole order’s).

= 5.5.0 (March 2, 2023) =
* **Improved Test.** WooCommerce Product Tests are now compatible with variable products.
* **Bug Fix.** Properly test if two split tests overlap.
* **Bug Fix.** Fix fatal error when using invalid namespace in WPML compat file.
* **Bug Fix.** Help icons in Settings screen should show help on click.
* **Bug Fix.** Require `regenerator-runtime` dependency on `nab-components` script only.

= 5.4.4 (February 17, 2023) =
* **New Feature.** Add two filters to throttle consecutive page view events in global tests.
* **Improvement.** Add margin to separate action buttons in result screen’s header.

= 5.4.3 (February 15, 2023) =
* **Improvement.** Add filter to enable/disable browsing site while previewing alternative content.
* **Improvement.** Use a better component to filter products by category and/or tag in bulk sale test.
* **Improvement.** Use WooCommerce’s _Products_ icon in WooCommerce Product Tests.
* **Improvement.** Wrap WooCommerce filters with our own to simplify the addition of new test types in the future.
* **Bug Fix.** Fix `array_diff` check to allow bulk sale test duplication.
* **Bug Fix.** Show alternative short description and product image in search results.
* **Bug Fix.** Keep existing pricing sale in WooCommerce Product tests if alternative price is not set.
* **Bug Fix.** Parse HTML entities in product tag and product category names.
* **Bug Fix.** Fix prices in variable products while running WooCommerce Bulk Sale test.
* **Bug Fix.** Set correct status `nab_paused_draft` to paused tests that can’t be resumed.

= 5.4.2 (February 9, 2023) =
* **Bug Fix.** Load product test hooks.
* **Bug Fix.** Add “alternative” argument in headline and product test sanitizers.

= 5.4.1 (February 9, 2023) =
* **Bug Fix.** Fix undefined key “deactivate” in plugin list customization.

= 5.4.0 (February 8, 2023) =
* **New Test.** Add WooCommerce Bulk Sale Test.
* **Improvement.** Format revenue stats in test results using WooCommerce’s settings.
* **Improvement.** Add new filter to track cart’s total value for computing revenue stats in a test: `nab_track_order_total`.
* **Bug Fix.** Fix font weight styles to make some labels (e.g. action views) slightly bolder.

= 5.3.11 (January 26, 2023) =
* **Improvement**. Add goal switcher in Overview page.
* **Bug Fix**. Add code to let ex-subscribers view heatmaps in split tests.
* **Bug Fix**. Rename `nonce` query args to `nabnonce` to prevent issues with public query vars.

= 5.3.10 (January 3, 2023) =
* **Bug Fix**. Prevent alternative preview dialog in experiment editor from autoclosing right after being opened.

= 5.3.9 (December 23, 2022) =
* **Improvement**. Add “Remove” button next to license key.
* **Bug Fix**. Add new method to compute body height safely, even when page is in Quirks Mode.
* **Bug Fix**. Display correct heatmap size after switching resolutions.

= 5.3.8 (November 9, 2022) =
* **WordPress 6.1 Compatibility**. Add compatibility with WordPress 6.1.
* **Bug Fix**. Fix duplication of widget tests.
* **Bug Fix**. Check if site has menus using custom endpoint to fix issue in WordPress 5.8.

= 5.3.7 (October 5, 2022) =
* **Bug Fix**. Use proper type definition of jQuery to track form submissions correctly.
* **Bug Fix**. Fix testing existing e-landing-pages.

= 5.3.6 (September 20, 2022) =
* **Bug Fix**. Detect when main script has been enqueued to properly track tests that trigger view events in footer.

= 5.3.5 (September 19, 2022) =
* **Bug Fix**. Refactor current screen detection to prevent multiple “Tests” items from showing up in Dashboard.
* **Bug Fix**. Show correct comments and comment count in variants when multiple post/page tests with global consistency are running.

= 5.3.4 (September 6, 2022) =
* **New Feature**. Add setting to disable auto tutorials.
* **Improvement**. Add new setting “Use control ID in variants” to ease compatibility with page builders.
* **Bug Fix**. Make sure cookies about visitor being tested and/or logged-in are properly set.
* **Bug Fix**. (Try to) get queried post ID using WPDB when everything else failed.
* **Bug Fix**. Remove `jquery` dependency in public script.
* **Bug Fix**. Use `absint` instead of `ceil` and `floor` to fix type error.
* **Bug Fix**. Fix JS error on WooCommerce when no tests are running.
* **Bug Fix**. Don’t suggest the control version might be the winner when it clearly isn’t.
* **Bug Fix**. Don’t show revenue data in test results when revenue tracking is disabled.
* **Bug Fix**. Overwrite product price when applying woocommerce variant.

= 5.3.3 (August 4, 2022) =
* **Improvement**. Allow experiment sorting by title, status, and/or date.
* **Improvement**. Add support for Custom Permalinks.
* **Improvement**. Add `nab_skip_scope_overlap_detection` filter to disable overlap detection when starting new tests.
* **Bug Fix**. Remove `nab-disabled-link` class from CSS selectors obtained using Nelio’s built-in CSS finder component.
* **Bug Fix**. Disable menu tests if current theme doesn’t support menus.
* **Bug Fix**. Tweak template tests to assume a post uses the default template if its template is not available in the current theme.

= 5.3.2 (July 25, 2022) =
* **New Feature**. Add new conversion action to track “add product to cart” events in WooCommerce.
* **New Feature**. Add tracking support for Formidable Forms.
* **Bug Fix**. Tweak code to check if test scopes overlap when using partial and full URLs.
* **Bug Fix**. Use variant permalink in canonical meta tag when test is against existing content.
* **Bug Fix**. Allow toggling of “Track revenue” checkbox in Conversion Goals.
* **Bug Fix**. Format start/stop dates in test list screen using site’s timezone.
* **Bug Fix**. Tweak date selector in test editor to select dates using site’s timezone.
* **Bug Fix**. Preview (and load) alternative home page correctly.
* **Bug Fix**. Get queried object ID correctly when accessing child pages/posts/cpts.
* **Bug Fix**. Fix WPML language switch in alternative content when disabling control IDs in alternatives.

= 5.3.1 (July 5, 2022) =
* **Bug Fix**. Fix front page hooks when testing the home page.
* **New Feature**. Enable “Tested Visitors” percentage setting in Basic plans.

= 5.3.0 (June 22, 2022) =
* **Improvement**. Refactor code to use TypeScript.

= 5.2.12 (June 14, 2022) =
* **Improvement**. Add support for Tom Usborne’s _GP Premium_.

= 5.2.11 (June 10, 2022) =
* **Bug Fix**. Remove PHP notice when checking if experiment can be resumed.
* **Bug Fix**. Remove PHP notice when filtering taxonomies on a post test.
* **Bug Fix**. Load alternative content correctly on custom post type tests.
* **Bug Fix**. Load alternative content in Page List block when required.
* **Bug Fix**. Use control URL in post tests with global consistency enabled.
* **Improvement**. Load alternative content when testing Elementor’s Landing Pages.

= 5.2.10 (June 1, 2022) =
* **Bug Fix**. Determine correct list of alternative post IDs on a tested page when other tests with global consistency are running.
* **Bug Fix**. Properly format long decimal number in “Improvement” chart.

= 5.2.9 (May 30, 2022) =
* **Bug Fix**. Add new function `nab_get_queried_object_id` to retrieve queried object’s ID when using plain permalinks.

= 5.2.8 (May 19, 2022) =
* **New Conversion Action**. Add support for [Nelio Forms](https://wordpress.org/plugins/nelio-forms/).
* **Bug Fix**. Fix “Unable to render heatmap” issue in heatmap results page.
* **Bug Fix**. Disable event tracking on tests without page views.
* **Bug Fix**. Use current CSS selector in CSS selector finder when it’s opened.
* **Bug Fix**. Bug fix in theme and template experiment editor that resulted in a WSOD.
* **Improvement**. Add `nabIsStaging` cookie when `nabisstaging` query arg is in the URL.
* Refactor internal stores to benefit from WordPress “newest” features.
* Update JavaScript dependencies.
* Bump minimum required WordPress version to 5.8.

= 5.2.7 (May 6, 2022) =
* **Improvement**. Start conversion tracking right after sending page views.
* **Bug Fix**. Track page view conversions when target page is tested against already existing page(s).
* **Bug Fix**. Track page views in page tests that use already existing variants when requesting a variant’s URL without the `nab` query arg.
* **Bug Fix**. Fix react hooks warning on old WordPress versions.
* Bump minimum required WordPress version to 5.6.

= 5.2.6 (May 2, 2022) =
* Tweak source code to fix issues reported by WordPress VIP.
* Update link to Nelio A/B Testing’s Terms and Conditions.

= 5.2.5 (April 27, 2022) =
* **Improvement**. Refactor source code to use React hooks instead of Higher-Order Components.
* **Improvement**. Use store names as provided by WordPress packages insted of hardcoded alternatives.
* **Improvement**. Improve error message to better explain what’s amiss when tracked URL in heatmap test is invalid.
* **Improvement**. Modify JavaScript conversion action component to add line breaks if needed and improve readability.
* **Improvement**. Disable menu tests if there aren’t any menus in the current site.
* **Bug Fix**. Fix undefined warning message in frontend while running a headline test.
* **Bug Fix**. Fix original preview in headline test.
* **Bug Fix**. Fix JavaScript error on old WordPress versions.
* **Bug Fix**. In CSS variant editor, tweak “Hide/Show Controls” button’s styles to make it always visible.
* **Bug Fix**. Load appropriate variant URL in CSS Selector modal when editing click action on page vs page test.
* **Bug Fix**. Fix variant colors in UI.
* **Bug Fix**. Fix animation when removing variants from a test.

= 5.2.4 (April 19, 2022) =
* **Bug Fix**. Fix undefined warning message in frontend.

= 5.2.3 (April 14, 2022) =
* **Bug Fix**. Retrieve alternative URLs in order on existing-content tests to load appropriate variant.

= 5.2.2 (April 13, 2022) =
* **Improvement**. Modify component to edit IP segments to allow adding multiple IPs at once using comma-separated values.
* **Improvement**. Add `nab_use_send_beacon_tracking` filter to customize JS tracking method.
* **Bug Fix**. Tweak tracking algorithm to track control views on non-post tests.
* **Bug Fix**. Tweak `nab_get_permalink` to prevent Fatal Error if called too soon.
* **Bug Fix**. Disable compatibility tweaks on page/post/cpt tests when testing against already-existing content.
* **Bug Fix**. Tweak alternative loader script to properly retrieve the current URL when viewing no `WP_Post` pages.

= 5.2.1 (March 28, 2022) =
* **Improvement**. Disable “Test against existing content” selector when editing a paused test.
* **Improvement**. Disable translation enqueuing on scripts that don’t have `wp-i18n` as a dependency.
* **Improvement**. Remove “Canonical Link” setting and use WordPress’ `get_canonical_url` default filter instead.
* **Bug Fix**. Track video playback events when video is loaded dynamically on page while scrolling down.
* **Bug Fix**. Fix blank editor screen on “old” WordPress versions.

= 5.2.0 (March 22, 2022) =
* **New Feature**. Test pages/post/custom post types against already existing (and published) content.
* **Improvement**. Replace state with `nab` query arg on tested pages (when possible) to skip JavaScript redirections.
* **Improvement**. Include front-end script only if required.
* **Improvement**. Use `navigator.sendBeacon` to track user events.
* **Improvement**. Track external links clicked using mouse’s middle button.
* **Bug Fix**. Track links when they include the preloaded `nab` query arg.
* **Bug Fix**. Fix “Subscribe”/“Add More Quota” buttons in Overview screen.
* **Bug Fix**. Show error notice when test creation fails.
* **Bug Fix**. Fix WPML critical error.

= 5.1.6 (March 14, 2022) =
* **Improvement**. Add `nab-preview` and `nab-heatmap` classes in page’s body when required.
* **Bug Fix**. Fix type of an `Experiment`’s alternatives, goals, segments, and scope.
* **Bug Fix**. Add `is_wp_error` check in quick experiment menu to prevent a fatal error on some setups.
* **Bug Fix**. Fix _undefined variable_ warning in widget tests.

= 5.1.5 (January 31, 2022) =
* **Bug Fix**. Fix return type in `useEffect`.

= 5.1.4 (January 31, 2022) =
* **Bug Fix**. Fix exception by plugin settings on plugin activation.

= 5.1.3 (January 28, 2022) =
* **WordPress 5.9**. Set plugin as compatible with WordPress 5.9.
* **Improvement**. Add Welcome Guides in admin screens.
* **Improvement**. Disable widget experiments if theme doesn’t support widgets.

= 5.1.2 (January 13, 2022) =
* **Bug Fix**. Tweak variant creation algorithm to fix character encoding issues on certain setups.
* **New Filter**. Add filter `nab_alternative_preview_link_duration` to tweak the expiration time of an alternative’s preview link.

= 5.1.1 (November 30, 2021) =
* **New Conversion Action**. Track YouTube video events.
* **Bug Fix**. Tweak variant creation algorithm to fix character encoding issues on certain setups.

= 5.1.0 (November 22, 2021) =
* **WooCommerce**. Track order revenues and tweak results page to include this metric.
* **WooCommerce**. Add new box in order screen to display the tests in which the customer participated.
* **Improvement**. Add new setting to preload query args in URLs and thus speed up page loading times.
* **Improvement**. Enable all test types to free users.
* **Bug Fix**. Prevent Cloudflare from “optimizing” (i.e. delaying the execution of) our JavaScript files.
* **Bug Fix**. Fix _Add Test_ button on WordPress.com sites.

= 5.0.21 (October 19, 2021) =
* **Improvement**. Add _Preview_ action to validate variants before starting a new test.
* **Bug Fix**. Tweak `trigger` and `convert` JS functions to track events after settings have been properly loaded.
* **Bug Fix**. Tweak test management to be able to stop paused tests.
* **Bug Fix**. Fix duplicated widgets after stopping a widget test.
* **Bug Fix**. Fix undefined key warnings in front-end when using test scopes.

= 5.0.20 (July 19, 2021) =
* **WordPress 5.8 Support**. [Add `regenerator-runtime` dependency in WordPress 5.8+](https://make.wordpress.org/core/2021/06/28/miscellaneous-developer-focused-changes-in-wordpress-5-8/).

= 5.0.19 (June 2, 2021) =
* **Bug Fix.** Fix CSS variant preview in test editor.
* **Bug Fix.** Add error notices in heatmap editor.
* **Bug Fix.** Enable template tests when theme has additional templates available.
* **Improvement.** Disable theme tests in multisite when there’s only one selectable theme.

= 5.0.18 (April 14, 2021) =
* **Improvement.** Add confirmation dialog before applying a variant.
* **Improvement.** Remove old jQuery dependency.
* **Improvement.** Show error message in UI when heatmap can’t be rendered.
* **Improvement.** Allow wildcards in IP address segments.
* **Bug Fix.** Tweak component to return empty array when post type has no templates.

= 5.0.17 (March 22, 2021) =
* **Bug Fix.** Use home URL in the _Account_ screen when showing “this site.”
* **Improvement.** Do not minify/combine Nelio A/B Testing scripts when using Siteground Optimizer plugin.

= 5.0.16 (March 3, 2021) =
* **Bug Fix.** Track events properly on the homepage when using Polylang.
* **Bug Fix.** Track events properly on the homepage when using WPML.
* **Bug Fix.** Add defaults sanitization in alternative attributes to remove some PHP notices.
* **Improvement.** Tweak the code to show the reason why a test can’t be started.
* **Improvement.** Add new filter to toggle short description replacement in WC product variations.
* **Improvement.** Add helper functions `nab_is_preview` and `nab_is_heatmap`.
* **Improvement.** Try to purge cache of NitroPack when needed.

= 5.0.15 (February 1, 2021) =
* **Improvement.** Modify account page to display agency subscriptions.

= 5.0.14 (January 15, 2021) =
* **Bug Fix.** Fix tested visitors range selector to allow value updates.
* **Bug Fix.** Maintain new conversion action and new segmentation rule panels open while editing them.

= 5.0.13 (December 14, 2020) =
* **Compatible with WordPress 5.6.**

= 5.0.12 (October 26, 2020) =
* **Fix.** Add timeout in _kickoff script_ to delay the window load fix implemented in previous version.

= 5.0.11 (October 9, 2020) =
* **Improvement.** Exclude Nelio scripts from WPRocket combination/minification processes to avoid incompatibilities.
* **Fix.** Add a call to `nabDoSingleAction( 'valid-content' )` in _kickoff script_ on window load to avoid possible WSOD.
* **Fix.** Add missing return statement in `nabAddSingleAction` helper function.
* **Fix.** Escape values in `add_query_arg` to fix bug when retrieving results from Nelio’s cloud.

= 5.0.10 (September 30, 2020) =
* **Improvement.** Extend custom event actions with a name to reuse them. You can now name a custom event conversion action. This way, triggering the custom action by its name will result in a conversion on all tests listening to it.
* **Improvement.** Modify alternative loader script to hide content using an overlay. This way, if there are any script on the page that need to know the size of the rendered DOM elements, said elements would be properly rendered behind the overlay (whereas, in previous versions, elements were actually hidden).
* **Improvement.** The plugin is now able to load alternative content during a post request. This way, when the browser receives the response, there’s no need to perform a JavaScript redirection, as this response already contains the content the visitor is supposed to see. You can disable this behavior using the `nab_can_load_alternative_content_on_post_request` filter.
* **Improvement.** Add new column in experiment list to show page views.
* **Fix.** Tweak alternative loader script to prevent infinite redirect loops.
* **Fix.** Edit heatmap script to set body’s `height` to `auto`. This guarantees that Nelio A/B Testing will be able to compute the body’s height in pixels and use that information to render the heatmap.
* **Fix.** Edit alternative loader script to support URLs with special characters.

= 5.0.9 (September 14, 2020) =
* **New Feature.** Plugin subscribers can now add segmentation rules to their tests, so that only specific segments are under test.
* **Fix.** When using WooCommerce’s shop page in a page view conversion action, visiting the shop page should trigger a conversion. Previous versions of the plugin didn’t, because the shop page wasn't detected as such by Nelio A/B Testing. This has now been fixed.
* **Fix.** When creating a CSS test, only administrators were able to edit CSS variants, even though editors should also be able to. This has now been fixed.
* **Fix.** Some click events couldn’t be tracked because the element they were listening to already had an event listener that prevented the event from reaching Nelio’s. This occurred because Nelio A/B Testing listeners were added to `document` instead of the element itself and relied on the even bubbling up. To overcome this limitation, the plugin now also tries to add a direct listener to the element itself.
* **Fix.** The plugin should always use original SEO data. This wasn’t the case when a page was built using page builders such as Divi or Elementor. (Note: the plugin is only compatible with Yoast SEO).
* **Fix.** Applying a winning variant didn’t work as expected if Polylang was enabled, as our plugin overwrote some Polylang taxonomies. This has now been fixed and Nelio A/B Testing ignores those taxonomies so that everything works as expected.
* **Fix.** The cookie `nabIsVisitorExcluded` wasn’t always properly set, which resulted in editors and admins participating in tests randomly. This cookie is now set during WordPress’ `set_logged_in_cookie` action, which occurs when the visitor is logging in and, therefore, when we know our own cookie can be properly set.
* **Fix.** Nelio A/B Testing’s `nab/data` store has a selector named `getActivePlugins`. This method should return an array with the list of active plugins, but sometimes it didn’t and it returned an object instead. This has now been fixed.
* **Improvement.** Test previews when using partial URLs in your scope select better candidates and thus show better previews.
* **Improvement.** When editing a CSS variant, you’re able to browse to any page on your site to see how the CSS snippet you write looks like. In the previous version, however, the preview was reset to the original page every time you saved the variant. This has now been fixed and saving a variant doesn’t reset the preview.
* **Improvement.** Added a new button in results page of a CSS test so that you can see the CSS snippet you created in each variant.
* **Improvement.** Flush cache of major systems when changing the status of a test.

= 5.0.8 (June 3, 2020) =
* **Improvement.** Added a new filter (`nab_ignore_trailing_slash_in_alternative_loading`) to select how our plugin checks if the current URL is equivalent to the URL the visitor is supposed to see. In particular, it tells our plugin if trailing slashes should be considered or not (namely, if `https://example.com/tested-page` is the same page as `https://example.com/tested-page/`).
* **Fix.** Form submissions and WooCommerce orders should only track a conversion for any given test if the visitor had seen the tested element of said test first. If they didn’t, the action shouldn’t become a conversion. The previous version failed to consider this.

= 5.0.7 (June 2, 2020) =
* **Improvement.** Sometimes, Nelio A/B Testing’s logo was retrieved using a GET request instead of accessing the file system directly. This has now been fixed.
* **Improvement.** This version includes a new filter to manage whether control ID should be used when loading alternative content built with Elementor: `nab_use_control_id_in_elementor_alternative`.
* **Improvement.** This version includes a new filter to prevent tests from running on certain URLs programmatically: `nab_{$experiment_type}_disable_experiment_in_url`.
* **Fix.** The previous version stopped the execution of our scripts on IE. Unfortunately, some scripts still triggered an error in IE. We fixed this by adding a polyfill for `Symbol`.
* **Fix.** Theme testing couldn’t load widgets properly. This has now been fixed.
* **Fix.** Line breaks in variants were automatically removed when using the Classic Editor. Apparently, this occurred because one of our admin scripts used `@wordpress/edit-post` as a dependency (in Gutenberg). This has now been fixed.
* **Fix.** Single custom meta fields that turned out to be an array didn’t work in variants, because of how WordPress manages “single” meta fields. To fix the issue, the filter that retrieves an alternative meta value should always retrieve the “full” (non-single) value and return it.
* **Fix.** Users with the free plan only see the plan info in the account page.
* **Fix.** Fixed warning when using `nab_woocommerce_sync_alternative` AJAX callback.
* **Fix.** Template tests didn’t always work. For instance, classnames included in the `body` tag weren’t correct. We’ve reimplemented the function that switches the tested template with one of its variants.
* **Fix.** Sometimes, the set of available test actions in _Tests_ screen was not correct. For instance, when a test was _Paused_, it was possible to either _Resume_ or _Start_ it. Only the first action made sense and the latter resulted in an error, which means it shouldn't be there in the first place. We’ve fixed these situations.

= 5.0.6 (April 14, 2020) =
* **Improvement.** Alternative loader script is no longer enqueued unless the current page is under test. This makes site loading a little bit faster.
* **Fix.** Template tests didn’t always work with custom post types when the tested template was the default template and said default template was `single.php` or `singular.php`. This has now been fixed.
* **Fix.** The plugin is now compatible with Instabuilder2. In previous versions, there were issues when creating variants from Instabuilder2 pages. This has now been fixed and alternative content is properly created.
* **Fix.** The plugin does no longer add `utm_referrer` param in URLs when redirecting the visitor from a tested page to the variant they’re supposed to see if said referrer is the same site.
* **Fix.** Improved management of URL parameters when loading alternative content.
* **Fix.** When duplicating a test, its description is also duplicated.
* **Fix.** Status icon in Dashboard is visible even when tests have no winner.
* **Fix.** Nelio A/B Testing doesn’t support IE and, therefore, none of our testing scripts should run on IE. We added a guard that checks if the browser is IE and, if it is, it stops the execution of our scripts.

= 5.0.5 (March 23, 2020) =
* **New Feature.** The plugin can now be used for free too!
* **Fix.** WooCommerce Order Completed actions didn’t work as expected. Under certain circumstances, the same order could trigger multiple conversions in a test, which was invalid. The plugin now keeps track of the already-synched orders to prevent this issue.

= 5.0.4 (March 16, 2020) =
* **New Features.** You can now tweak the minimum number of page views and confidence values required to call a test winner.
* **Improvement.** Tested in WordPress 5.4 and styles adapted to it.
* **Fix.** The plugin is now compatible with Elementor. In previous versions, there were issues with styling and CSS. Nelio A/B Testing can now detect when a page is built using Elementor and switches to the appropriate CSS if needed.
* **Fix.** The plugin is now compatible with Divi. In previous versions, there were issues with styling and CSS. Nelio A/B Testing can now detect when a page is built using Divi and switches to the appropriate CSS if needed.
* **Fix.** The plugin is now compatible with OptimizePress. In previous versions, an OptimizePress original page ended up looking like one of its variants because OptimizePress ended up caching alternative content as if it were the original copy. Nelio now detects when OptimizePress is caching a page and makes sure the cache is properly set. Just keep in mind you have to enable Nelio A/B Testing’s scripts and styles in OptimizePress’ settings.
* **Fix.** The plugin is now compatible with Leadpages (but it requires some tweaking). In previous versions, the plugin was unable to load alternative content and/or track any events from a Leadpage. This is because Leadpages doesn’t use anyof WordPress’ functions and simply replaces the final HTML with the HTML generated in their platform. To overcome this issue, edit Leadpages’ plugin and add an `apply_filters('leadpages_html', $html)` in `App/Helpers/LeadpageType.php` when it’s echoing the `$html`.
* **Fix.** Custom meta fields that were an array didn’t work in variants, because our plugin wrapped the original array in a new array. This has now been fixed.
* **Fix.** When running template tests, Nelio A/B Testing tried to load alternative content on all pages of your website, because it didn’t know if a certain page used the tested template or not. With this new version, the plugin is now able to determine whether the requested page uses the tested template, so alternative content loading is more precise.
* **Fix.** When Nelio A/B Testing is installed, it temporarily hides the content of a page to check if it’s under test and, if it is, redirect the visitor to the appropriate variation with no screen flickering. If the page contained a YouTube video or any other element that needs the content to be visible, this might be an issue and the element might not have the correct dimensions. To fix this, the plugin now triggers a `resize` event once the content is visible again, so that these elements know they should probably fix their sizes.

= 5.0.3 (February 24, 2020) =
* **Improvement.** The plugin now uses a cookie to determine whether logged-in users participate in a test or not, instead of relying on including or excluding the tracking script in the final HTML.
* **Fix.** Remove warning when calling `column_date` method statically.
* **Fix.** Given any page or post, there should be at most one test running testing it. In the previous version, it was possible to have more than one test testing the same element. This has now been fixed.
* **Fix.** When retrieving alternative post metas, results where inconsistent if the post meta was an array. This has now been fixed.
* **Fix.** Gravity Form Conversion Actions didn’t track form submissions properly (apparently, the ID of the submitted form was a `string` instead of an `int`). This has now been fixed.
* **Fix.** Gravity Form Conversion Actions should show the name of the selected form, but they didn’t in the results page of a test (resulting in users not being able to tell what they were actually testing).

= 5.0.2 (February 3, 2020) =
* **Improvement.** If the plugin is running on a staging site (and it detects the site as such), the plugin doesn’t track any events. This is the intended behavior, but users might not be aware of it. This version adds a warning in the plugin’s UI letting them know that the current site has been identified as a staging site.
* **Fix.** While editing a variant, test icons in the post editor screen looked stretched sometimes. This has now been fixed.
* **Fix.** Fixed a PHP Notice when trying to index a char in an empty string.

= 5.0.1 (January 23, 2020) =
* **Fix.** When using Beaver Builder, some variants used styles defined in control version. This has now been fixed.
* **Fix.** A hook in the `admin_body_class` filter didn’t always return a valid list of `$classes`, which could break the UI. This has now been fixed.

= 5.0.0 (January 14, 2020) =
* **Complete Redesign of Nelio A/B Testing!**
* **Improved UI and UX.** Nelio A/B Testing 5.0 uses the new technologies included in WordPress 5.3, offering a more elegant, intuitive, reponsive, and easier-to-use interface.
* **Under the hood.** The plugin has been completely rewritten to make it more reliable and faster.
* **New cloud.** We’ve moved our cloud from Google AppEngine to Amazon Web Services.
