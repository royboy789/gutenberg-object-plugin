import { CleanFilter } from './CleanFilter';

export class CoreCoverImage extends CleanFilter {

  constructor() {
    super( 'core-cover-image' );
  }

  hookCallback( attributes, name ) {
    attributes.title = wp.element.renderToString( attributes.title );
    return attributes;
  }

}