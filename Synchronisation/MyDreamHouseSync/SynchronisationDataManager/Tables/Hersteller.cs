using System;
using System.Collections.Generic;
using System.Data;
using System.Linq;
using System.Text;
using System.Threading.Tasks;
using static SynchronisationShared.SharedEnums;

namespace SynchronisationDataManager.Tables
{
    class Hersteller : Table
    {
        public override string GetInsertString(DataRow row, DatabaseType type)
        {
            string query = "insert into hersteller (hersteller_id,name) values (";

            query = AddParam(query, row, 0, DataType.NUMERIC, false);
            query = AddParam(query, row, 1, DataType.STRING, true);

            return query;
        }
    }
}
