# Gutenberg Array Plugin
The purpose of this plugin is to save Gutenberg (New WordPress Editor) data as an array in the database

## WHY
While the new UI for the WordPress Editor is amazing, the data as it is stored lends a lot ot be desired with HTML comments as a basis for data

## WHERE
Data will be saved in a new database table `[prefix]_gutes_arrays`

## API
Included is 2 new API endpoints to save and get the data:  
* `wp-json/gutes-db/v1/[post-id]` - Supports __GET__ & __POST__ 

## Hooks
To send the data to the API to save we must first transform data. Using `wp.hooks` You can tie into this process by adding a filter  
* namespace - 'gutes_array'
* filter name - `clean_data_[hyphenated-block-name]`
* data - data sent and returned is an array of the attributes

__EXAMPLE__    
`wp.hooks.addFilter( 'clean_data_core-paragraph', 'gutes-array', callback );`  