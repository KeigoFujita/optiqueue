<?php

namespace App\Models;

use Database\Factories\ProductMovementFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductMovement extends Model
{
    /** @use HasFactory<ProductMovementFactory> */
    use HasFactory;
    /*
    |--------------------------------------------------------------------------
    | Movement Type & Category Reference
    |--------------------------------------------------------------------------
    |
    | Industry-standard inventory movement types and categories for
    | eyewear / optical retail.
    |
    | movement_type:
    |   'in'          – Stock received / added to inventory
    |   'out'         – Stock removed / deducted from inventory
    |   'adjustment'  – Manual inventory count correction
    |
    | movement_category (per type):
    |
    |   IN:
    |     'purchase_order'       – Stock received from supplier
    |     'initial_stock'        – Opening balance / first-time stock-in
    |     'return_from_customer' – Customer return restocked
    |     'transfer_in'          – Transferred from another location/warehouse
    |
    |   OUT:
    |     'sale'        – Sold to customer
    |     'damage'      – Damaged / broken during handling or display
    |     'expired'     – Expired or obsolete stock (e.g., lens solution)
    |     'sample'      – In-store demo / display sample
    |     'transfer_out'– Transferred to another location/warehouse
    |
    |   ADJUSTMENT:
    |     'positive_adjustment'  – Count found more than expected (surplus)
    |     'negative_adjustment'  – Count found less than expected (shrinkage)
    |     'write_off'            – Total loss (theft, unrecoverable damage)
    |
    */

    protected $fillable = [
        'product_id',
        'movement_type',     // 'in', 'out', 'adjustment'
        'movement_category', // See reference above
        'quantity',          // Positive integer; deducted when movement_type = 'out' in business logic
        'movement_date',
        'reference_id',      // Optional: order ID, PO number, transfer slip, etc.
    ];

    protected function casts(): array
    {
        return [
            'movement_date' => 'date',
            'quantity' => 'integer',
        ];
    }

    /**
     * The product this movement belongs to.
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
