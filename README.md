# Gutenberg Object Plugin
The purpose of this plugin is to save Gutenberg (New WordPress Editor) data as an array in the database which is accessible via the REST API.

## Installation
* Clone
* Run `composer install`
* Run `npm install`
* `npm run dev` / `npm run build`
* Activate plugin.

## WHY
While the new UI for the WordPress Editor is amazing, the data as it is stored lends a lot ot be desired with HTML comments as a basis for data

## WHERE
Data will be saved in a new database table `[prefix]_gutes_arrays`

## REST API
I have included a filter to adda `editor_block` to the normal post content response.

## API ENDPOINTS
Includes 1 new route:  
* `wp-json/gutes-db/v1/[post-id]` - Supports __GET__ & __POST__ 

### GET  
`GET: wp-json/gutes-db/v1/[post-id]`
__Returns__
* __is_gutes__: Is the post created with Gutenberg
* __post_id__: Post ID
* __data__: Gutenberg Data
* ___embedded['post']__: _optional with \_embed_ - response from WP REST API for post  

  
### SAVE
`POST: wp-json/gutes-db/v1/[post-id]`
* __id__ - _required_ - post ID
* __gutes_data__ - _required_ - Data array

## Hooks
To send the data to the API to save we must first transform data. Using `wp.hooks` You can tie into this process by adding a filter  
* namespace - 'gutes_array'
* filter name - `clean_data_[hyphenated-block-name]`
* data - data sent and returned is an array of the attributes

## Adding editor_blocks to other CPT Responses
### V 1.1.0+
Do you have another CPT (post type) that you are using Gutenberg with? Great! all you have to do is define `GUTENBERG_OBJECT_PLUGIN_CPTS` before `rest_api_init` with a comma separated list of CPTs.
```
add_action( 'init', 'my_custom_cpts', 10 );
function my_custom_cpts() {
    if ( ! defined( 'GUTENBERG_OBJECT_PLUGIN_CPTS' ) ) {
        define( 'GUTENBERG_OBJECT_PLUGIN_CPTS', 'product,page,other_cpt' );    
    }
}
```

Once `GUTENBERG_OBJECT_PLUGIN_CPTS` is defined as a comma separated list the `editor_block` data will apaper in that CPT's API response

__EXAMPLE__    
`wp.hooks.addFilter( 'clean_data_core-paragraph', 'gutes-array', callback );`  

## Helper Functions
* `get_editor_blocks( $post_id );` - returns array of block data 
