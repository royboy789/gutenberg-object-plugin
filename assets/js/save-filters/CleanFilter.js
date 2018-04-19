export class CleanFilter {

  constructor( block ) {
    wp.hooks.addFilter( 'clean_data_' + block, 'gutes-array', this.hookCallback.bind(this) );
  }

  hookCallback( attributes, name ) {
    return attributes;
  }

}