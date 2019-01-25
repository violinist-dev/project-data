# project-data

[![Build Status](https://travis-ci.org/violinist-dev/project-data.svg?branch=master)](https://travis-ci.org/violinist-dev/project-data)
[![Coverage Status](https://coveralls.io/repos/github/violinist-dev/project-data/badge.svg?branch=master)](https://coveralls.io/github/violinist-dev/project-data?branch=master)

Project data value object.

## About this package

This package exists so one can create a value object from a Drupal node, and then deserialize it in all kinds of application that has nothing to do with Drupal.

This way we can pass it to workers that does not run Drupal, and still access all the values of the node we are interested in.
