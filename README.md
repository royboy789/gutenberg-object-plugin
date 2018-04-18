# Gutenberg Array Plugin
The purpose of this plugin is to save Gutenberg (New WordPress Editor) data as an array in the database

## WHY
While the new UI for the WordPress Editor is amazing, the data as it is stored lends a lot ot be desired with HTML comments as a basis for data

## WHERE
Data will be saved in a new database table `[prefix]_gutes_arrays`

## API
Included is 2 new API endpoints to save and get the data:  
* `wp-json/gutes-db/v1/[post-id]` - Supports __GET__ & __POST__ 