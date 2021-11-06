<?php

namespace Magnit56\PhpInterview;

use Exception;
use Tightenco\Collect\Support\Collection;
use Magnit56\PhpInterview\Discount;

class Cart
{
	private $consumer;
	private $items = [];

	public function __construct(ConsumerInterface $consumer)
	//вместо ?User передается ConsumerInterface
	//применяется типо паттерн nullObject класс Guest, если пользователь не зарегистрирован

	//в том месте где применяем (типо как в Laravel):
	//$consumer = (Auth::check()) ? new User($sex, $age) : new Guest();
	//$cart = new Cart($consumer);
	{
		$this->consumer = $consumer;
	}

	public function getConsumer(): ConsumerInterface
	{
		return $this->consumer;
	}

	public function addItem(Product $item)
	{
		$oldCount = $this->items[$item->getId()]['count'] ?? 0;
		$newCount = $oldCount + 1;
		$this->items[$item->getId()] = [
			'item_id' => $item->getId(),
			'count' => $newCount,
		];
		return $this;
	}

	public function minusItem($id)
	{
		if (collect($this->items[$id])->isEmpty()) {
			return;
		}
		if ($this->items[$id]['count'] == 1) {
			$this->destroyItem($id);
			return;
		}
		$this->items[$id]['count']--;
		return $this;
	}

	public function destroyItem($id)
	{
		$this->items = collect($this->items)->forget($id)->all();
		return $this;
	}

	public function flush()
	{
		$this->items = [];
		return $this;
	}

	public function setItemCount($id, $number)
	{
		if (!(is_int($number) && $number > 0)) {
			throw new Exception('Количество должно быть натуральным числом!');
		}
		$this->items[$id]['count'] = $number;
		return $this;
	}

	public function getTotalAmount(): int
	{
		return array_reduce($this->items, function ($acc, $item) {
			$id = $item['item_id'];
			$count = $item['count'];
			$product = new Product($id);
			return $acc + $product->getPrice() * $count;
		}, 0);
	}

	public function getDiscountedTotalAmount(): int
	{
		return ($this->getTotalAmount() - $this->getDiscount());
	}

	public function getDiscount()
	{
		return (new Discount())->getTotalDiscount($this);
	}

	public function getItems(): array
	{
		return $this->items;
	}

	public function getCartData()
	{
		$totalAmount = $this->getTotalAmount();
		$generalDiscount = $this->getDiscount();
		$totalDiscountedAmount = $this->getDiscountedTotalAmount();
		$discountPercent = ($totalAmount == 0) ? 0 : $generalDiscount / $totalAmount;

		$items = array_map(function ($item) use ($discountPercent) {
			$id = $item['item_id'];
			$count = $item['count'];
			$product = new Product($id);
			$price = $product->getPrice();
			$discountPrice = $price * $discountPercent;
			$discountedPrice = $price - $discountPrice;
			$amount = $count * $price;
			$discountAmount = $count * $discountPrice;
			$discountedAmount = $count * $discountedPrice;
			return [
				'id' => $id,
				'count' => $count,
				'price' => $price,
				'discount' => $discountPrice,
				'discountedPrice' => $discountedPrice,
				'amount' => $amount,
				'discountAmount' => $discountAmount,
				'discountedAmount' => $discountedAmount,
			];
		}, $this->items);
		return [
			'items' => $items,
			'totalAmount' => $totalAmount,
			'discount' => $generalDiscount,
			'totalDiscountedAmount' => $totalDiscountedAmount,
		];
	}
}
