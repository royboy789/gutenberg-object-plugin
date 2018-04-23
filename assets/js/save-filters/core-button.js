import { CleanFilter } from './CleanFilter';

export class CoreButton extends CleanFilter {

  constructor() {
    super( 'core-button' );
  }

  hookCallback( name, attributes, innerBlocks ) {
    attributes.text = wp.element.renderToString( attributes.text );
    return attributes;
  }

}