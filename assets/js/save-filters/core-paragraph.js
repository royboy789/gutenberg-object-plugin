import { CleanFilter } from './CleanFilter';

export class CoreParagraph extends CleanFilter {

  constructor() {
    super( 'core-paragraph' );
  }

  hookCallback( attributes, name ) {
    attributes.content = wp.element.renderToString( attributes.content );
    return attributes;
  }

}