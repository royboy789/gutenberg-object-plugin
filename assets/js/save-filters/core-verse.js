import { CleanFilter } from './CleanFilter';

export class CoreVerse extends CleanFilter {

  constructor() {
    super( 'core-verse' );
  }

  hookCallback( attributes, name, innerBlocks ) {
    attributes.content = wp.element.renderToString( attributes.content );
    return attributes;
  }

}