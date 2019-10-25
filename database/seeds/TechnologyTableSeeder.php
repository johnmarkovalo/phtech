<?php

use Illuminate\Database\Seeder;

class TechnologyTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('technology')->insert([
            ['name' => 'Laravel', 'description' => 'Laravel is a web application framework with expressive, elegant syntax. We’ve already laid the foundation — freeing you to create without sweating the small things.'],
            ['name' => 'Vue.js', 'description' => 'Vue.js is an open-source Model–view–viewmodel JavaScript framework for building user interfaces and single-page applications.'],
            ['name' => 'PHP', 'description' => 'PHP: Hypertext Preprocessor is a general-purpose programming language originally designed for web development. It was originally created by Rasmus Lerdorf in 1994; the PHP reference implementation is now produced by The PHP Group.'],
            ['name' => 'Kotlin', 'description' => 'Kotlin is a cross-platform, statically typed, general-purpose programming language with type inference. Kotlin is designed to interoperate fully with Java, and the JVM version of its standard library depends on the Java Class Library.'],
            ['name' => 'Android', 'description' => 'Android is a mobile operating system based on a modified version of the Linux kernel and other open source software, designed primarily for touchscreen mobile devices such as smartphones and tablets.'],
            ['name' => 'Java', 'description' => 'Java is a general-purpose programming language that is class-based, object-oriented, and designed to have as few implementation dependencies as possible.'],
            ['name' => 'JavaScript', 'description' => 'JavaScript, often abbreviated as JS, is a high-level, interpreted scripting language that conforms to the ECMAScript specification. JavaScript has curly-bracket syntax, dynamic typing, prototype-based object-orientation, and first-class functions.'],
            ['name' => '.Net', 'description' => '.NET Framework is a software framework developed by Microsoft that runs primarily on Microsoft Windows. It includes a large class library named as Framework Class Library and provides language interoperability across several programming languages.'],
            ['name' => 'C#', 'description' => 'C# is a general-purpose, multi-paradigm programming language encompassing strong typing, lexically scoped, imperative, declarative, functional, generic, object-oriented, and component-oriented programming disciplines.'],
            ['name' => 'React', 'description' => 'React is a JavaScript library for building user interfaces. It is maintained by Facebook and a community of individual developers and companies.'],
            ['name' => 'HTML', 'description' => 'Hypertext Markup Language is the standard markup language for documents designed to be displayed in a web browser. It can be assisted by technologies such as Cascading Style Sheets and scripting languages such as JavaScript.'],
            ['name' => 'Angular', 'description' => 'Angular is a TypeScript-based open-source web application framework led by the Angular Team at Google and by a community of individuals and corporations. Angular is a complete rewrite from the same team that built AngularJS.'],
        ]);
    }
}
