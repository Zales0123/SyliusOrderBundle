<?php

/*
 * This file is part of the Sylius package.
 *
 * (c) Paweł Jędrzejewski
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sylius\Bundle\OrderBundle\Templating\Helper;

use Sylius\Component\Order\Modifier\OrderItemQuantityModifierInterface;
use Sylius\Component\Order\Model\OrderInterface;
use Sylius\Component\Order\Context\CartContextInterface;
use Sylius\Component\Resource\Factory\FactoryInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\Templating\Helper\Helper;

class CartHelper extends Helper
{
    /**
     * @var CartContextInterface
     */
    protected $cartContext;

    /**
     * @var FactoryInterface
     */
    protected $cartItemFactory;

    /**
     * @var FormFactoryInterface
     */
    protected $formFactory;

    /**
     * @var OrderItemQuantityModifierInterface
     */
    protected $orderItemQuantityModifier;

    /**
     * @param CartContextInterface $cartContext
     * @param FactoryInterface $cartItemFactory
     * @param FormFactoryInterface $formFactory
     * @param OrderItemQuantityModifierInterface $orderItemQuantityModifier
     */
    public function __construct(
        CartContextInterface $cartContext,
        FactoryInterface $cartItemFactory,
        FormFactoryInterface $formFactory,
        OrderItemQuantityModifierInterface $orderItemQuantityModifier
    ) {
        $this->cartContext = $cartContext;
        $this->cartItemFactory = $cartItemFactory;
        $this->formFactory = $formFactory;
        $this->orderItemQuantityModifier = $orderItemQuantityModifier;
    }

    /**
     * @return OrderInterface|null
     */
    public function getCurrentCart()
    {
        return $this->cartContext->getCart();
    }

    /**
     * @param array $options
     *
     * @return FormView
     */
    public function getItemFormView(array $options = [])
    {
        $cartItem = $this->cartItemFactory->createNew();
        $this->orderItemQuantityModifier->modify($cartItem, 1);

        $form = $this->formFactory->create('sylius_cart_item', $cartItem, $options);

        return $form->createView();
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'sylius_cart';
    }
}