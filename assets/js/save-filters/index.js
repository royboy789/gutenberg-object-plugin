import { CoreParagraph } from './core-paragraph';
import { CoreCoverImage } from './core-cover-image';
import { CoreButton } from './core-button';
import { CoreTextColumns } from './core-text-columns';
import { CoreColumns } from './core-columns';
import { CoreImage } from './core-image';
import { CoreEmbed } from './core-embed';
import { CoreHeading } from './core-heading';
import { CoreList } from './core-list';
import { CorePreFormatted } from './core-preformatted';

export class SaveFilters {
  constructor() {
    new CoreParagraph();
    new CoreCoverImage();
    new CoreButton();
    new CoreTextColumns();
    new CoreColumns();
    new CoreImage();
    new CoreEmbed();
    new CoreHeading();
    new CoreList();
    new CorePreFormatted();
  }
}
