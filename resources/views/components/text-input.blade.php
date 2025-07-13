@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'border-white dark:border-white dark:bg-amber-100 dark:text-gray-900 focus:border-amber-500 dark:focus:border-amber-600 focus:ring-amber-500 dark:focus:ring-amber-600 rounded-md shadow-sm']) }}>
