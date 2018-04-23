import { CleanFilter } from './CleanFilter';

export class CoreCoverImage extends CleanFilter {

  constructor() {
    super( 'core-cover-image' );
  }

  hookCallback( name, attributes, innerBlocks ) {
    attributes.title = wp.element.renderToString( attributes.title );
    return attributes;
  }

}