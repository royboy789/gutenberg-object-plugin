import { CleanFilter } from './CleanFilter';

export class CoreTable extends CleanFilter {

  constructor() {
    super( 'core-table' );
  }

  hookCallback( attributes, name, innerBlocks ) {
    attributes.content = wp.element.renderToString( attributes.content );
    return attributes;
  }

}