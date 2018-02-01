<?php
  /*Below code will register module.*/
	\Magento\Framework\Component\ComponentRegistrar::register(
		\Magento\Framework\Component\ComponentRegistrar::MODULE,
		'Envoy_Test',
		__DIR__
	);