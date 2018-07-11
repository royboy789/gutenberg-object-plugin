import { SaveBlock } from './block-save/block-save';
import { SaveFilters } from './save-filters/index.js';

jQuery( document ).ready(function(){
  new SaveBlock();
  new SaveFilters();
});