<?php

/*
 * This file is part of the Sylius package.
 *
 * (c) Paweł Jędrzejewski
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace spec\Sylius\Bundle\OrderBundle\NumberAssigner;

use PhpSpec\ObjectBehavior;
use Sylius\Bundle\OrderBundle\NumberAssigner\OrderNumberAssigner;
use Sylius\Bundle\OrderBundle\NumberAssigner\OrderNumberAssignerInterface;
use Sylius\Bundle\OrderBundle\NumberGenerator\OrderNumberGeneratorInterface;
use Sylius\Component\Order\Model\OrderInterface;

/**
 * @mixin OrderNumberAssigner
 *
 * @author Grzegorz Sadowski <grzegorz.sadowski@lakion.com>
 */
class OrderNumberAssignerSpec extends ObjectBehavior
{
    function let(OrderNumberGeneratorInterface $numberGenerator)
    {
        $this->beConstructedWith($numberGenerator);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Sylius\Bundle\OrderBundle\NumberAssigner\OrderNumberAssigner');
    }

    function it_implements_order_number_assigner_interface()
    {
        $this->shouldImplement(OrderNumberAssignerInterface::class);
    }


    function it_assigns_number_to_order(
        OrderInterface $order,
        OrderNumberGeneratorInterface $numberGenerator
    ) {
        $order->getNumber()->willReturn(null);

        $numberGenerator->generate()->willReturn('00000007');
        $order->setNumber('00000007')->shouldBeCalled();

        $this->assignNumber($order);
    }
}
