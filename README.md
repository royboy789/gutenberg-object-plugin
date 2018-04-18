# Gutenberg Array Plugin
The purpose of this plugin is to save Gutenberg (New WordPress Editor) data as an array in the database

## Installation
Developer Plugin Only
* Clone
* Run `npm install`
* `npm run dev` / `npm run build`
* Activate plugin.

## WHY
While the new UI for the WordPress Editor is amazing, the data as it is stored lends a lot ot be desired with HTML comments as a basis for data

## WHERE
Data will be saved in a new database table `[prefix]_gutes_arrays`

## API
Included is 2 new API endpoints to save and get the data:  
* `wp-json/gutes-db/v1/[post-id]` - Supports __GET__ & __POST__ 

## GET  
`GET: wp-json/gutes-db/v1/[post-id]`
__Returns__
* __is_gutes__: Is the post created with Gutenberg
* __post_id__: Post ID
* __data__: Gutenberg Data
* ___embedded['post']__: _optional with \_embed_ - response from WP REST API for post  

  
## SAVE
`POST: wp-json/gutes-db/v1/[post-id]`
* __id__ - _required_ - post ID
* __gutes_data__ - _required_ - Data array

## Hooks
To send the data to the API to save we must first transform data. Using `wp.hooks` You can tie into this process by adding a filter  
* namespace - 'gutes_array'
* filter name - `clean_data_[hyphenated-block-name]`
* data - data sent and returned is an array of the attributes

__EXAMPLE__    
`wp.hooks.addFilter( 'clean_data_core-paragraph', 'gutes-array', callback );`  