# project-data

[![Test](https://github.com/violinist-dev/project-data/actions/workflows/test.yml/badge.svg)](https://github.com/violinist-dev/project-data/actions/workflows/test.yml)
[![Coverage Status](https://coveralls.io/repos/github/violinist-dev/project-data/badge.svg?branch=master)](https://coveralls.io/github/violinist-dev/project-data?branch=master)
[![Violinist enabled](https://img.shields.io/badge/violinist-enabled-brightgreen.svg)](https://violinist.io)

Project data value object.

## About this package

This package exists so one can create a value object from a Drupal node, and then deserialize it in all kinds of application that has nothing to do with Drupal.

This way we can pass it to workers that does not run Drupal, and still access all the values of the node we are interested in.
