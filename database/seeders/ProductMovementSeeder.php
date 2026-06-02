<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Product;
use App\Models\ProductMovement;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class ProductMovementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * Creates an inventory movement trail for every product. The net sum
     * of all movements (IN - OUT) equals the product's `stocks` column.
     */
    public function run(): void
    {
        $products = Product::all();
        $now = Carbon::now();

        foreach ($products as $product) {
            $stocks = $product->stocks;
            $movements = $this->buildMovementSet($stocks, $product, $now);

            foreach ($movements as $movement) {
                ProductMovement::create($movement);
            }
        }
    }

    /**
     * Build a realistic set of movements whose net equals the target stock.
     *
     * All quantities are positive integers. Movement direction is determined
     * by the movement_type column ('in' adds, 'out' / 'adjustment' subtracts).
     */
    private function buildMovementSet(int $targetStock, Product $product, Carbon $now): array
    {
        $movements = [];
        $daysAgo = rand(60, 180);

        // 1. Initial stock (always present)
        $initialIn = max($targetStock + rand(5, 30), 15);
        $movements[] = [
            'product_id' => $product->id,
            'movement_type' => 'in',
            'movement_category' => 'initial_stock',
            'quantity' => $initialIn,
            'movement_date' => (clone $now)->subDays($daysAgo)->format('Y-m-d'),
            'reference_id' => 'PO-INI-' . mb_str_pad((string) $product->id, 4, '0', STR_PAD_LEFT),
        ];

        $totalIn = $initialIn;
        $totalOut = 0;

        // 2. Additional purchase / restock (50% chance)
        if (rand(0, 1) && $targetStock > 5) {
            $extraQty = rand(5, 25);
            $daysAgo -= rand(10, 40);
            $movements[] = [
                'product_id' => $product->id,
                'movement_type' => 'in',
                'movement_category' => 'purchase_order',
                'quantity' => $extraQty,
                'movement_date' => (clone $now)->subDays(max($daysAgo, 1))->format('Y-m-d'),
                'reference_id' => 'PO-' . mb_strtoupper(mb_substr(md5((string) rand()), 0, 6)),
            ];
            $totalIn += $extraQty;
        }

        // 3. Sale movements (multiple batches)
        $remainingForOut = $totalIn - $targetStock;

        if ($remainingForOut > 0) {
            $numSales = rand(1, 3);

            for ($i = 0; $i < $numSales; $i++) {
                $saleQty = $i < $numSales - 1
                    ? rand(1, max(1, (int) ($remainingForOut / ($numSales - $i))))
                    : $remainingForOut;

                if ($saleQty <= 0) {
                    continue;
                }

                $daysAgo -= rand(3, 20);
                $movements[] = [
                    'product_id' => $product->id,
                    'movement_type' => 'out',
                    'movement_category' => 'sale',
                    'quantity' => $saleQty,
                    'movement_date' => (clone $now)->subDays(max($daysAgo, 0))->format('Y-m-d'),
                    'reference_id' => 'ORD-' . mb_strtoupper(mb_substr(md5((string) rand()), 0, 8)),
                ];
                $totalOut += $saleQty;
                $remainingForOut -= $saleQty;
            }
        }

        // 4. Damage / loss (occasional)
        if (rand(0, 2) === 0 && $remainingForOut > 0) {
            $damageQty = rand(1, min(3, $remainingForOut));
            $daysAgo -= rand(5, 15);
            $movements[] = [
                'product_id' => $product->id,
                'movement_type' => 'out',
                'movement_category' => 'damage',
                'quantity' => $damageQty,
                'movement_date' => (clone $now)->subDays(max($daysAgo, 0))->format('Y-m-d'),
                'reference_id' => null,
            ];
            $totalOut += $damageQty;
            $remainingForOut -= $damageQty;
        }

        // 5. Adjustment if net doesn't match (safety net)
        $net = $totalIn - $totalOut;
        $diff = $net - $targetStock;

        if ($diff !== 0) {
            $movements[] = [
                'product_id' => $product->id,
                'movement_type' => 'adjustment',
                'movement_category' => $diff > 0 ? 'negative_adjustment' : 'positive_adjustment',
                'quantity' => abs($diff),
                'movement_date' => (clone $now)->subDays(1)->format('Y-m-d'),
                'reference_id' => 'ADJ-' . mb_str_pad((string) $product->id, 4, '0', STR_PAD_LEFT),
            ];
        }

        return $movements;
    }
}
