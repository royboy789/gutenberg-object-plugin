import { CleanFilter } from './CleanFilter';

export class CoreQuote extends CleanFilter {

  constructor() {
    super( 'core-quote' );
  }

  hookCallback( attributes, name, innerBlocks ) {
    for( let [index] of attributes.value.entries() ) {
      attributes.value[index] = wp.element.renderToString( attributes.value[index].children );
    }
    attributes.citation = wp.element.renderToString( attributes.citation );
    return attributes;
  }

}