import { CleanFilter } from './../CleanFilter';

export class WDS_CallToAction_Block extends CleanFilter {

  constructor() {
    super( 'wds-call-to-action' );
  }

  hookCallback( attributes, name, innerBlocks ) {
    return attributes;
  }

}