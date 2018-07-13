import { CleanFilter } from './../CleanFilter';

export class WDS_TwoColumn_Block extends CleanFilter {

  constructor() {
    super( 'wds-two-column' );
  }

  hookCallback( attributes, name, innerBlocks ) {
    if ( attributes.contentLeft ) {
      attributes.contentLeft = wp.element.renderToString( attributes.contentLeft );
    }

    if ( attributes.contentRight ) {
      attributes.contentRight = wp.element.renderToString( attributes.contentRight );
    }

    return attributes;
  }

}