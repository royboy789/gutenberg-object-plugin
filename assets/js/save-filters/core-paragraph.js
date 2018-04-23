import { CleanFilter } from './CleanFilter';

export class CoreParagraph extends CleanFilter {

  constructor() {
    super( 'core-paragraph' );
  }

  hookCallback( name, attributes, innerBlocks ) {
    attributes.content = wp.element.renderToString( attributes.content );
    return attributes;
  }

}