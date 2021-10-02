#!/bin/bash
Name=$2
Cmd=$3

Start()
{
    if [[ -n "$Name" && -n "$Cmd" ]]; then
        if [[! screen -list | grep -q "myscreen"]]; then
            echo "Starting Server..."
            screen -dmS $Name sh; screen -S $Name -X stuff $Cmd+"\n"
            echo "Started Server!"
        else
            echo "Server has already Started!"
            exit 1
        fi
    else
        echo "usage: start [name] [cmd]" 
        exit 1
    fi
}

Stop()
{
    if [[ -n "$Name" ]]; then
        if [[! screen -list | grep -q $Name]]; then
            echo "Server has not been started!"
            exit 1
        else
            echo "Shutting down Server..."
            screen -S $Name -X quit
            echo "Succesfully shutdown!"
            exit 1
        fi
    else
        echo "usage: stop [name]" 
        exit 1
    fi
}

Status()
{
    if [[ -n "$Name" ]]; then
        if [[! screen -list | grep -q $Name]]; then
            echo "started"
            exit 1
        else
            echo "Stopped"
            exit 1
        fi
    else
        echo "usage: status [name]" 
        exit 1
    fi
}

Console()
{
    if [[ -n "$Name" ]]; then
        if [[! screen -list | grep -q $Name]]; then
            screen -r $name
        else
            echo "Server has not been started!"
            exit 1
        fi
    else
        echo "usage: status [name]" 
        exit 1
    fi
}

Cmd()
{
    if [[ -n "$Name" && -n "$Cmd    " ]]; then
        if [[! screen -list | grep -q $Name]]; then
            screen -S $Name -X stuff $Cmd+"\n"
        else
            echo "Server has not been started!"
            exit 1
        fi
    else
        echo "usage: cmd [cmd]" 
        exit 1
    fi
}

case "${1}" in
	"") echo "No option was specified."; exit 1 ;;
    start)  Start;;
    stop)   Stop;;
    status) Status;;
    console) Console;;
    cmd)   Cmd;;
    *)  echo "Unknown arg '${1}'."; exit 1 ;;
esac


