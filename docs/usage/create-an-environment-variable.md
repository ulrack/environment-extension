# Ulrack Environment Extension - Create an environment variable

This package add the ability to create and manage environment variables for
projects. This is being managed through the services layer, so multiple
declarations can be made per file. To create an environment variable create a
file in the `configuration/environment` directory with the following content.

```json
{
    "foo": {
        "default": null
    }
}
```

A default value can be declared for an environment variable through the
`default` field. The environment can now be accessed anywhere in the project
through the services layer by calling it with `@{environment.foo}`. The
variable can be managed with commands.

## List command

The list command can be used to retrieve a list of all availible environment
variables. This command is `bin/application environment list`.

## Get command

The get command can be used to retrieve the JSON representation of a value of
an environment variable. This command accepts one parameter which is `key` (or
shorthand `k`). It can be invoked like this
`bin/application environment get --key="foo"`.

## Set command

The set command can be used to alter the value of the environment variable in
the storage. It accepts two parameters, the `key` variable (same as for the
`get` command). And the `value` (or shorthand `v`) parameter which accepts a
JSON string representation of the value. If the value parameter is omitted
it can be added interactively.

## Further reading

[Back to usage index](index.md)

[Installation](installation.md)
