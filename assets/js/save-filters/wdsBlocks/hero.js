import { CleanFilter } from './../CleanFilter';

export class WDS_Hero_Block extends CleanFilter {

  constructor() {
    super( 'wds-hero' );
  }

  hookCallback( attributes, name, innerBlocks ) {
    return attributes;
  }

}