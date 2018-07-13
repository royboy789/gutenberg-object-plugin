import { CleanFilter } from './../CleanFilter';

export class WDS_CallToAction_Block extends CleanFilter {

  constructor() {
    super( 'wds-call-to-action' );
  }

  hookCallback( attributes, name, innerBlocks ) {
    attributes.message = wp.element.renderToString( attributes.message );
    return attributes;
  }

}