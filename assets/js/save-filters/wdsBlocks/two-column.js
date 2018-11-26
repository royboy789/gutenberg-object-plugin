import { CleanFilter } from './../CleanFilter';

export class WDS_TwoColumn_Block extends CleanFilter {

  constructor() {
    super( 'wds-two-column' );
  }

  hookCallback( attributes, name, innerBlocks ) {
    return attributes;
  }

}