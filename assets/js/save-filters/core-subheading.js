import { CleanFilter } from './CleanFilter';

export class CoreSubhead extends CleanFilter {

  constructor() {
    super( 'core-subhead' );
  }

  hookCallback( attributes, name, innerBlocks ) {
    attributes.content = wp.element.renderToString( attributes.content );
    return attributes;
  }

}