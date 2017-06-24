using System;
using System.Collections.Generic;
using System.Data;
using System.Linq;
using System.Text;
using System.Threading.Tasks;
using static SynchronisationShared.SharedEnums;

namespace SynchronisationDataManager.Tables
{
    public class Benutzer : Table
    {
        public override string GetInsertString(DataRow row, DatabaseType type)
        {
            string query = "insert into " + GetTableName() + " (benutzer_id,joomla_user_id) values (";

            query = AddParam(query, row, 0, DataType.NUMERIC, false);
            query = AddParam(query, row, 1, DataType.NUMERIC, true);

            return query;
        }

        public override string GetPrimaryKeyColumn()
        {

            return "benutzer_id";
        }

        public override string GetTableName()
        {
            return "benutzer";
        }
    }
}
