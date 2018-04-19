#!/bin/sh

if [ "$1" = "travis" ]
then
    psql -U postgres -c "CREATE DATABASE rec1ev_test;"
    psql -U postgres -c "CREATE USER rec1ev PASSWORD 'rec1ev' SUPERUSER;"
else
    [ "$1" != "test" ] && sudo -u postgres dropdb --if-exists rec1ev
    [ "$1" != "test" ] && sudo -u postgres dropdb --if-exists rec1ev_test
    [ "$1" != "test" ] && sudo -u postgres dropuser --if-exists rec1ev
    sudo -u postgres psql -c "CREATE USER rec1ev PASSWORD 'rec1ev' SUPERUSER;"
    [ "$1" != "test" ] && sudo -u postgres createdb -O rec1ev rec1ev
    sudo -u postgres createdb -O rec1ev rec1ev_test
    LINE="localhost:5432:*:rec1ev:rec1ev"
    FILE=~/.pgpass
    if [ ! -f $FILE ]
    then
        touch $FILE
        chmod 600 $FILE
    fi
    if ! grep -qsF "$LINE" $FILE
    then
        echo "$LINE" >> $FILE
    fi
fi
