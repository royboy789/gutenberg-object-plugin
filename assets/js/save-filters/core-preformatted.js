import { CleanFilter } from './CleanFilter';

export class CorePreformatted extends CleanFilter {

  constructor() {
    super( 'core-preformatted' );
  }

  hookCallback( attributes, name, innerBlocks ) {
    attributes.content = wp.element.renderToString( attributes.content );
    return attributes;
  }

}