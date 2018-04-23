import { CleanFilter } from './CleanFilter';

export class CoreButton extends CleanFilter {

  constructor() {
    super( 'core-button' );
  }

  hookCallback( attributes, name, innerBlocks ) {
    attributes.text = wp.element.renderToString( attributes.text );
    return attributes;
  }

}