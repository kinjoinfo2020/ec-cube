<?php

/*
 * This file is part of EC-CUBE
 *
 * Copyright(c) LOCKON CO.,LTD. All Rights Reserved.
 *
 * http://www.lockon.co.jp/
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Eccube\Tests\Service\Payment;

use Eccube\Tests\EccubeTestCase;

class PaymentMethodTest extends EccubeTestCase
{
    public function testConstructorInjection()
    {
        $this->markTestSkipped();

        $Customer = $this->createCustomer();
        $Order = $this->createOrder($Customer);

        $form = $this->getMockBuilder('Symfony\Component\Form\Test\FormInterface')->getMock();
        $paymentMethod = $this->container->get($Order->getPayment()->getMethodClass());
        $paymentMethod->setFormType($form);
        $paymentMethod->setOrder($Order);

        $this->assertInstanceOf(\Eccube\Service\Payment\Method\Cash::class, $paymentMethod);

        $dispatcher = $paymentMethod->apply(); // 決済処理中.
        $this->assertFalse($dispatcher);

        $PaymentResult = $paymentMethod->checkout(); // 決済実行
        $this->assertTrue($PaymentResult->isSuccess());
    }
}