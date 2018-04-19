#!/bin/sh

BASE_DIR=$(dirname $(readlink -f "$0"))
if [ "$1" != "test" ]
then
    psql -h localhost -U rec1ev -d rec1ev < $BASE_DIR/rec1ev.sql
fi
psql -h localhost -U rec1ev -d rec1ev_test < $BASE_DIR/rec1ev.sql
