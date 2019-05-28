<?php declare(strict_types=1);

/**
 * Filter
 *
 * Global filters handler.
 *
 * @package Protein
 * @author  "Stefano Azzolini"  <lastguest@gmail.com>
 */

namespace Protein;

abstract class Filter {
    use Filters {
          filter       as add;
          filterSingle as single;
          filterRemove as remove;
          filterWith   as with;
    }
}
