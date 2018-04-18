export class CoreParagraph {

  constructor() {
    wp.hooks.addFilter( 'clean_data_core-paragraph', 'gutes-array', this.hookCallback.bind(this) );
  }

  hookCallback( data ) {
    console.log( data );
    return data;
  }

}