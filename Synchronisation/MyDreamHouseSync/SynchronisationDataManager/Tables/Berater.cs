using System;
using System.Collections.Generic;
using System.Data;
using System.Linq;
using System.Text;
using System.Threading.Tasks;
using static SynchronisationShared.SharedEnums;

namespace SynchronisationDataManager.Tables
{
    class Berater : Table
    {
        public override string GetInsertString(DataRow row, DatabaseType type)
        {
            string query = "insert into berater (berater_id,hersteller_id,benutzer_id,bild) values (";

            query = AddParam(query, row, 0, DataType.NUMERIC, false);
            query = AddParam(query, row, 1, DataType.NUMERIC, false);
            query = AddParam(query, row, 2, DataType.NUMERIC, false);
            query = AddParam(query, row, 3, DataType.STRING, true);

            return query;
        }
    }
}
