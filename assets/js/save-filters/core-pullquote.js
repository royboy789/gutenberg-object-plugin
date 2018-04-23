import { CleanFilter } from './CleanFilter';

export class CorePullquote extends CleanFilter {

  constructor() {
    super( 'core-pullquote' );
  }

  hookCallback( attributes, name, innerBlocks ) {
    for( let [index] of attributes.value.entries() ) {
      attributes.value[index].children = wp.element.renderToString( attributes.value[index].children );
    }
    attributes.citation = wp.element.renderToString( attributes.citation );
    return attributes;
  }

}